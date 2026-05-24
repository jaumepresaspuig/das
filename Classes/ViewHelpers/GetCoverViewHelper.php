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

class GetCoverViewHelper extends AbstractViewHelper
{
    /**
     * @var ConfigurationManagerInterface
     */
    public function initializeArguments()
    {
        $this->registerArgument('description', 'string', 'Album description', '', true);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $description = explode(PHP_EOL, $this->arguments['description']);
        $size = 300;
        $thumbnailsFolder = 'audio_thumbnails';
        $thumbnail = '';
        if (array_key_exists(1, $description) && $description[1] !== '') {
            $description[0] = str_replace(["\r\n", "\r", "\n"], '', $description[0]);
            $description[1] = str_replace(["\r\n", "\r", "\n"], '', $description[1]);
            $thumbnail = 'fileadmin/' . $thumbnailsFolder . '/' . str_replace(' ', '-', $description[0] . ' ' . $description[1]) . '.jpg';
            if (!file_exists($thumbnail)) {
                if (!is_dir('fileadmin/' . $thumbnailsFolder)) {
                    mkdir('fileadmin/' . $thumbnailsFolder, 0770, true);
                }
                $url = 'https://itunes.apple.com/search?term=' . urlencode($description[0] . ' ' . $description[1]) . '&entity=album&limit=5';
                $opts = ['http' => ['method' => 'GET', 'header' => "User-Agent: PHP\r\n"]];
                $context = stream_context_create($opts);
                $json = file_get_contents($url, false, $context);
                if ($json !== false) {
                    $data = json_decode($json, true);
                    if (!empty($data['results'])) {
                        $best = null;
                        foreach ($data['results'] as $r) {
                            $titleMatch = strcasecmp($r['collectionName'], $description[1]) === 0;
                            $artistMatch = stripos($r['artistName'], $description[0]) !== false;
                            if ($titleMatch && $artistMatch) {
                                $best = $r;
                                break;
                            }
                            if (!$best) {
                                $best = $r;
                            }
                        }
                        if ($best) {
                            $art100 = $best['artworkUrl100'];
                            $art = preg_replace('/\/\d+x\d+bb\./', "/{$size}x{$size}bb.", $art100);
                            $externalFile = GeneralUtility::getUrl($art);
                            if ($externalFile) {
                                $tempFileName = tempnam(sys_get_temp_dir(), 'sp_package_das');
                                $handle = fopen($thumbnail, 'w');
                                fwrite($handle, $externalFile);
                                unlink($tempFileName);
                            } else {
                                $thumbnail = '';
                            }
                        }
                    }
                }
            }
        }
        return ($thumbnail) ? '/' . $thumbnail : '';
    }
}
