<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$languageFilePrefix = 'LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:';

$tempColumns = [
    'tx_das_cover' => [
        'displayCond' => 'FIELD:width:=:0',
        'label' => $languageFilePrefix . 'sys_file_metadata.tx_das_cover',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'jpg,jpeg,png,gif,webp',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns(
    'sys_file_metadata',
    $tempColumns
);

ExtensionManagementUtility::addToAllTCAtypes(
    'sys_file_metadata',
    'tx_das_cover',
    '',
    'after:keywords'
);
