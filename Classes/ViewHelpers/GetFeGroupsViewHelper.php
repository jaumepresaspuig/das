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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetFeGroupsViewHelper extends AbstractViewHelper
{
    /**
     * @return array
     */
    public function render(): array
    {
        $feGroups = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');
        $res = $queryBuilder
            ->select('uid', 'title')
            ->from('fe_groups')
            ->executeQuery()
            ->fetchAllAssociative();
        foreach ($res as $row) {
            array_push(
                $feGroups,
                [
                    0 => $row['title'],
                    1 => $row['uid']
                ]
            );
        }
        return $feGroups;
    }
}
