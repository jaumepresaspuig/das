<?php

declare(strict_types=1);

/*
 * This file is part of the "das" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Jp\Das\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class GetThumbnailViewHelper extends AbstractViewHelper
{
    /**
     * @var ConfigurationManagerInterface
     */
    public function initializeArguments()
    {
        $this->registerArgument('provider', 'string', 'Provider: YouTube or Vimeo', '', true);
        $this->registerArgument('identifier', 'string', 'Video identifier', '', true);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $provider = $this->arguments['provider'];
        $identifier = $this->arguments['identifier'];
        $thumbnailsFolder = 'video_thumbnails';
        $thumbnail = 'fileadmin/' . $thumbnailsFolder . '/' . $provider . '_' . $identifier . '.jpg';
        if (!file_exists($thumbnail)) {
            if (!is_dir('fileadmin/' . $thumbnailsFolder)) {
                mkdir('fileadmin/' . $thumbnailsFolder, 0770, true);
            }
            if ($provider == 'vimeo') {
                $jsonFile = GeneralUtility::getUrl('http://vimeo.com/api/v2/video/' . $identifier . '.json');
                if ($jsonFile) {
                    $json = json_decode($jsonFile, true);
                    $externalFileUrl = $json[0]['thumbnail_large'];
                }
            } else {
                $externalFileUrl = 'https://img.youtube.com/vi/' . $identifier . '/sddefault.jpg';
            }
            if ($externalFileUrl) {
                $externalFile = GeneralUtility::getUrl($externalFileUrl);
                if ($externalFile) {
                    $tempFileName = tempnam(sys_get_temp_dir(), 'sp_package_das');
                    $handle = fopen($thumbnail, 'w');
                    fwrite($handle, $externalFile);
                    unlink($tempFileName);
                }
            }
        }
        return $thumbnail;
    }
}
