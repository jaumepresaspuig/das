<?php

declare(strict_types=1);

/*
 * This file is part of the "das" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Jp\Das\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetFileContentViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('filepath', 'string', '', false);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $fileContent = '';
        $filePath = $this->arguments['filepath'];
        if ($filePath !== null && $filePath !== '') {
            if (str_starts_with($filePath, '/fileadmin')) {
                if (file_exists($filePath)) {
                    $fileContent = file_get_contents($filePath);
                }
            } else {
                $fileContent = file_get_contents($filePath);
            }
        }
        return $fileContent;
    }
}
