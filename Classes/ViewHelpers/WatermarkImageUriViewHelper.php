<?php

declare(strict_types=1);

namespace Jp\Das\ViewHelpers;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class WatermarkImageUriViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('srcImage', 'string', 'The source image.', true);
        $this->registerArgument('width', 'string', 'Image width in pixels. Add c to crop, for example 200c', false, '');
        $this->registerArgument('height', 'string', 'Image height in pixels. Add c to crop, for example 200c', false, '');
        $this->registerArgument('crop', 'string', 'Use the crop data stored on the FAL image object', false, '');
        $this->registerArgument('watermarkImage', 'string', 'The watermark image.', true);
        $this->registerArgument('watermarkPosition', 'string', 'Watermark position', false, 'bottom-right');
        $this->registerArgument('watermarkOpacity', 'int', 'Watermark opacity from 1 to 100', false, 50);
        $this->registerArgument('watermarkSize', 'int', 'Watermark width as a percentage of the processed source image width', false, 25);
    }

    public function render(): string
    {
        $srcFile = $this->getFile((string)$this->arguments['srcImage']);
        $watermarkFile = $this->getFile((string)$this->arguments['watermarkImage']);

        $srcPath = $srcFile->getForLocalProcessing(false);
        $watermarkPath = $watermarkFile->getForLocalProcessing(false);

        if (!is_string($srcPath) || !is_file($srcPath)) {
            throw new \RuntimeException('Unable to access the source image.', 1725450001);
        }

        if (!is_string($watermarkPath) || !is_file($watermarkPath)) {
            throw new \RuntimeException('Unable to access the watermark image.', 1725450002);
        }

        $sourceImage = $this->loadImage($srcPath);
        $watermarkImage = $this->loadImage($watermarkPath);

        $sourceImage = $this->applyFalCropIfRequired(
            $sourceImage,
            $srcFile,
            (bool)$this->arguments['crop']
        );

        $sourceImage = $this->resizeSourceImage(
            $sourceImage,
            (string)$this->arguments['width'],
            (string)$this->arguments['height']
        );

        $watermarkSize = max(1, min(100, (int)$this->arguments['watermarkSize']));
        $watermarkOpacity = max(1, min(100, (int)$this->arguments['watermarkOpacity']));

        $sourceWidth = imagesx($sourceImage);
        $watermarkWidth = max(1, (int)round($sourceWidth * ($watermarkSize / 100)));

        $watermarkImage = $this->resizePreservingRatio(
            $watermarkImage,
            $watermarkWidth
        );

        $this->applyWatermark(
            $sourceImage,
            $watermarkImage,
            (string)$this->arguments['watermarkPosition'],
            $watermarkOpacity
        );

        $extension = strtolower((string)$srcFile->getProperty('extension'));

        if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            throw new \RuntimeException(
                'Only JPG and PNG source images are supported.',
                1725450003
            );
        }

        $extension = $extension === 'jpeg' ? 'jpg' : $extension;

        $cacheDirectory = Environment::getPublicPath() . '/typo3temp/assets/watermarks';

        GeneralUtility::mkdir_deep($cacheDirectory);

        $cropData = $this->arguments['crop'];

        $cacheKey = sha1(implode('|', [
            $srcFile->getIdentifier(),
            (string)$srcFile->getModificationTime(),
            $watermarkFile->getIdentifier(),
            (string)$watermarkFile->getModificationTime(),
            (string)$this->arguments['width'],
            (string)$this->arguments['height'],
            is_string($cropData) ? $cropData : serialize($cropData),
            (string)$this->arguments['watermarkPosition'],
            (string)$watermarkOpacity,
            (string)$watermarkSize,
        ]));

        $outputPath = $cacheDirectory . '/' . $cacheKey . '.' . $extension;

        if (!is_file($outputPath)) {
            if ($extension === 'png') {
                imagealphablending($sourceImage, false);
                imagesavealpha($sourceImage, true);

                if (!imagepng($sourceImage, $outputPath, 6)) {
                    throw new \RuntimeException(
                        'Unable to write the processed PNG image.',
                        1725450004
                    );
                }
            } else {
                if (!imagejpeg($sourceImage, $outputPath, 90)) {
                    throw new \RuntimeException(
                        'Unable to write the processed JPG image.',
                        1725450005
                    );
                }
            }
        }

        imagedestroy($sourceImage);
        imagedestroy($watermarkImage);

        return $this->getPublicUri($outputPath);
    }

    private function getFile(string $source): File
    {
        /** @var ResourceFactory $resourceFactory */
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);

        if (ctype_digit($source)) {
            return $resourceFactory->getFileObject((int)$source);
        }

        return $resourceFactory->getFileObjectFromCombinedIdentifier($source);
    }

    private function loadImage(string $path): \GdImage
    {
        $imageInfo = @getimagesize($path);

        if (!is_array($imageInfo)) {
            throw new \RuntimeException(
                'The file is not a valid image.',
                1725450006
            );
        }

        $mimeType = $imageInfo['mime'] ?? '';

        if (!in_array($mimeType, ['image/jpeg', 'image/png'], true)) {
            throw new \RuntimeException(
                'Only JPG and PNG images are supported.',
                1725450007
            );
        }

        $image = @imagecreatefromstring((string)file_get_contents($path));

        if (!$image instanceof \GdImage) {
            throw new \RuntimeException(
                'Unable to load the image.',
                1725450008
            );
        }

        imagealphablending($image, true);
        imagesavealpha($image, true);

        return $image;
    }

    private function applyFalCropIfRequired(
        \GdImage $image,
        File $file,
        bool $enabled
    ): \GdImage {
        if (!$enabled) {
            return $image;
        }

        $cropData = $this->arguments['crop'];

        if (is_string($cropData)) {
            $cropData = json_decode($cropData, true);
        }

        if (!is_array($cropData)) {
            return $image;
        }

        /*
         * TYPO3 format:
         *
         * crop
         * └── default
         *     └── cropArea
         */
        $cropArea = $cropData['default']['cropArea'] ?? null;

        if (!is_array($cropArea)) {
            return $image;
        }

        foreach (['x', 'y', 'width', 'height'] as $requiredKey) {
            if (!array_key_exists($requiredKey, $cropArea)) {
                return $image;
            }
        }

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);

        /*
         * TYPO3 stores cropArea values as normalized fractions between 0 and 1.
         */
        $x = (int)round((float)$cropArea['x'] * $sourceWidth);
        $y = (int)round((float)$cropArea['y'] * $sourceHeight);

        $cropWidth = (int)round(
            (float)$cropArea['width'] * $sourceWidth
        );

        $cropHeight = (int)round(
            (float)$cropArea['height'] * $sourceHeight
        );

        /*
         * Keep the crop rectangle inside the source image.
         */
        $x = max(0, min($sourceWidth - 1, $x));
        $y = max(0, min($sourceHeight - 1, $y));

        $cropWidth = max(
            1,
            min($sourceWidth - $x, $cropWidth)
        );

        $cropHeight = max(
            1,
            min($sourceHeight - $y, $cropHeight)
        );

        $croppedImage = imagecreatetruecolor(
            $cropWidth,
            $cropHeight
        );

        imagealphablending($croppedImage, false);
        imagesavealpha($croppedImage, true);

        $transparent = imagecolorallocatealpha(
            $croppedImage,
            0,
            0,
            0,
            127
        );

        imagefill(
            $croppedImage,
            0,
            0,
            $transparent
        );

        imagecopy(
            $croppedImage,
            $image,
            0,
            0,
            $x,
            $y,
            $cropWidth,
            $cropHeight
        );

        imagedestroy($image);

        return $croppedImage;
    }

    private function resizeSourceImage(
        \GdImage $image,
        string $widthSpec,
        string $heightSpec
    ): \GdImage {
        $widthData = $this->parseDimension($widthSpec);
        $heightData = $this->parseDimension($heightSpec);

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);

        if ($widthData === null && $heightData === null) {
            return $image;
        }

        $targetWidth = $widthData['value'] ?? null;
        $targetHeight = $heightData['value'] ?? null;

        if ($targetWidth === null && $targetHeight !== null) {
            $targetWidth = (int)round(
                $sourceWidth * ($targetHeight / $sourceHeight)
            );
        }

        if ($targetHeight === null && $targetWidth !== null) {
            $targetHeight = (int)round(
                $sourceHeight * ($targetWidth / $sourceWidth)
            );
        }

        $targetWidth = max(1, (int)$targetWidth);
        $targetHeight = max(1, (int)$targetHeight);

        $mustCrop = ($widthData['crop'] ?? false) || ($heightData['crop'] ?? false);

        if (!$mustCrop) {
            $ratio = min(
                $targetWidth / $sourceWidth,
                $targetHeight / $sourceHeight
            );

            $targetWidth = max(1, (int)round($sourceWidth * $ratio));
            $targetHeight = max(1, (int)round($sourceHeight * $ratio));

            return $this->resizeImage(
                $image,
                $targetWidth,
                $targetHeight
            );
        }

        /*
         * Crop-to-fill behaviour for values such as 200c x 200c.
         */
        $scale = max(
            $targetWidth / $sourceWidth,
            $targetHeight / $sourceHeight
        );

        $scaledWidth = max(1, (int)round($sourceWidth * $scale));
        $scaledHeight = max(1, (int)round($sourceHeight * $scale));

        $scaledImage = $this->resizeImage(
            $image,
            $scaledWidth,
            $scaledHeight
        );

        $croppedImage = imagecreatetruecolor($targetWidth, $targetHeight);

        imagealphablending($croppedImage, false);
        imagesavealpha($croppedImage, true);

        $transparent = imagecolorallocatealpha(
            $croppedImage,
            0,
            0,
            0,
            127
        );

        imagefill($croppedImage, 0, 0, $transparent);

        $sourceX = max(0, (int)floor(($scaledWidth - $targetWidth) / 2));
        $sourceY = max(0, (int)floor(($scaledHeight - $targetHeight) / 2));

        imagecopy(
            $croppedImage,
            $scaledImage,
            0,
            0,
            $sourceX,
            $sourceY,
            $targetWidth,
            $targetHeight
        );

        imagedestroy($scaledImage);
        imagedestroy($image);

        return $croppedImage;
    }

    private function resizePreservingRatio(
        \GdImage $image,
        int $targetWidth
    ): \GdImage {
        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);

        $targetHeight = max(
            1,
            (int)round($sourceHeight * ($targetWidth / $sourceWidth))
        );

        return $this->resizeImage($image, $targetWidth, $targetHeight);
    }

    private function resizeImage(
        \GdImage $image,
        int $width,
        int $height
    ): \GdImage {
        $resizedImage = imagecreatetruecolor($width, $height);

        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);

        $transparent = imagecolorallocatealpha(
            $resizedImage,
            0,
            0,
            0,
            127
        );

        imagefill($resizedImage, 0, 0, $transparent);

        imagecopyresampled(
            $resizedImage,
            $image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            imagesx($image),
            imagesy($image)
        );

        return $resizedImage;
    }

    private function applyWatermark(
        \GdImage $sourceImage,
        \GdImage $watermarkImage,
        string $position,
        int $opacity
    ): void {
        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        $watermarkWidth = imagesx($watermarkImage);
        $watermarkHeight = imagesy($watermarkImage);

        $margin = max(5, (int)round($sourceWidth * 0.02));

        $x = match ($position) {
            'top-left', 'middle-left', 'bottom-left' => $margin,
            'top-center', 'middle-center', 'bottom-center' =>
                (int)round(($sourceWidth - $watermarkWidth) / 2),
            'top-right', 'middle-right', 'bottom-right' =>
                $sourceWidth - $watermarkWidth - $margin,
            default => $sourceWidth - $watermarkWidth - $margin,
        };

        $y = match ($position) {
            'top-left', 'top-center', 'top-right' => $margin,
            'middle-left', 'middle-center', 'middle-right' =>
                (int)round(($sourceHeight - $watermarkHeight) / 2),
            'bottom-left', 'bottom-center', 'bottom-right' =>
                $sourceHeight - $watermarkHeight - $margin,
            default => $sourceHeight - $watermarkHeight - $margin,
        };

        $x = max(0, min($sourceWidth - $watermarkWidth, $x));
        $y = max(0, min($sourceHeight - $watermarkHeight, $y));

        /*
         * Apply global opacity while retaining the PNG alpha channel.
         */
        $opacityImage = imagecreatetruecolor(
            $watermarkWidth,
            $watermarkHeight
        );

        imagealphablending($opacityImage, false);
        imagesavealpha($opacityImage, true);

        $transparent = imagecolorallocatealpha(
            $opacityImage,
            0,
            0,
            0,
            127
        );

        imagefill($opacityImage, 0, 0, $transparent);

        for ($watermarkY = 0; $watermarkY < $watermarkHeight; $watermarkY++) {
            for ($watermarkX = 0; $watermarkX < $watermarkWidth; $watermarkX++) {
                $rgba = imagecolorat($watermarkImage, $watermarkX, $watermarkY);

                $red = ($rgba >> 16) & 0xFF;
                $green = ($rgba >> 8) & 0xFF;
                $blue = $rgba & 0xFF;
                $alpha = ($rgba >> 24) & 0x7F;

                $newAlpha = 127 - (int)round(
                    (127 - $alpha) * ($opacity / 100)
                );

                $color = imagecolorallocatealpha(
                    $opacityImage,
                    $red,
                    $green,
                    $blue,
                    max(0, min(127, $newAlpha))
                );

                imagesetpixel(
                    $opacityImage,
                    $watermarkX,
                    $watermarkY,
                    $color
                );
            }
        }

        imagealphablending($sourceImage, true);

        imagecopy(
            $sourceImage,
            $opacityImage,
            $x,
            $y,
            0,
            0,
            $watermarkWidth,
            $watermarkHeight
        );

        imagedestroy($opacityImage);
    }

    /**
     * Parses values such as:
     *
     * 100
     * 100c
     */
    private function parseDimension(string $value): ?array
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        if (!preg_match('/^(\d+)(c)?$/i', $value, $matches)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid image dimension "%s". Expected values such as 200 or 200c.',
                    $value
                ),
                1725450009
            );
        }

        return [
            'value' => max(1, (int)$matches[1]),
            'crop' => isset($matches[2]) && strtolower($matches[2]) === 'c',
        ];
    }

    private function getPublicUri(string $absolutePath): string
    {
        $publicPath = rtrim(Environment::getPublicPath(), DIRECTORY_SEPARATOR);
        $absolutePath = str_replace('\\', '/', $absolutePath);
        $publicPath = str_replace('\\', '/', $publicPath);

        if (!str_starts_with($absolutePath, $publicPath . '/')) {
            throw new \RuntimeException(
                'The generated image is outside the public directory.',
                1725450010
            );
        }

        return ltrim(substr($absolutePath, strlen($publicPath)), '/');
    }
}
