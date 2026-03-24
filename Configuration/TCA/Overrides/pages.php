<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$languageFilePrefix = 'LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:pages.';

$tempColumns = [
    'tx_das_logo' => [
        'label' => $languageFilePrefix . 'logo',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'jpg,jpeg,png,gif,webp',
            'appearance' => [
                'fileUploadAllowed' => 0
            ]
        ],
    ],
    'tx_das_structureddata' => [
        'label' => $languageFilePrefix . 'structured_data',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'structured_data.json',
                    'value' => 'json'
                ],
                [
                    'label' => $languageFilePrefix . 'structured_data.microdata',
                    'value' => 'microdata'
                ],
                [
                    'label' => $languageFilePrefix . 'structured_data.rdfa',
                    'value' => 'rdfa'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => 'json'
        ]
    ],
    'tx_das_showlanguageselector' => [
        'label' => $languageFilePrefix . 'show_language_selector',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_navigationlevels' => [
        'label' => $languageFilePrefix . 'navigation_levels',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '1',
                    'value' => '1'
                ],
                [
                    'label' => '2',
                    'value' => '2'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '1'
        ]
    ],
    'tx_das_searchpageuid' => [
        'label' => $languageFilePrefix . 'search_page_uid',
        'description' => $languageFilePrefix . 'search_page_uid.description',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'group',
            'minitems' => 0,
            'allowed' => 'pages',
            'maxitems' => 1,
            'size' => 1,
            'default' => 0,
            'suggestOptions' => [
               'default' => [
                  'additionalSearchFields' => 'nav_title, alias, url',
                  'addWhere' => 'AND pages.doktype = 1'
               ]
            ]
        ]
    ],
    'tx_das_breadcrumb' => [
        'label' => $languageFilePrefix . 'breadcrumb',
        'description' => $languageFilePrefix . 'breadcrumb.description',
        'onChange' => 'reload',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'breadcrumb.0',
                    'value' => '0'
                ],
                [
                    'label' => $languageFilePrefix . 'breadcrumb.1',
                    'value' => '1'
                ],
                [
                    'label' => $languageFilePrefix . 'breadcrumb.2',
                    'value' => '2'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '0'
        ]
    ],
    'tx_das_breadcrumbseparator' => [
        'label' => $languageFilePrefix . 'breadcrumb_separator',
        'displayCond' => [
            'AND' => [
                'FIELD:is_siteroot:REQ:true',
                'FIELD:tx_das_breadcrumb:!=:0'
            ]
        ],
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'size' => '2',
            'default' => '/'
        ]
    ],
    'tx_das_showpagetitle' => [
        'label' => $languageFilePrefix . 'show_page_title',
        'description' => $languageFilePrefix . 'show_page_title.description',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_bstheme' => [
        'label' => $languageFilePrefix . 'bstheme',
        'displayCond' => 'FIELD:is_siteroot:REQ:true',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '',
                    'value' => ''
                ],
                [
                    'label' => $languageFilePrefix . 'bstheme.auto',
                    'value' => 'auto'
                ],
                [
                    'label' => $languageFilePrefix . 'bstheme.light',
                    'value' => 'light'
                ],
                [
                    'label' => $languageFilePrefix . 'bstheme.dark',
                    'value' => 'dark'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => ''
        ]
    ],
    'tx_das_megamenu' => [
        'label' => $languageFilePrefix . 'mega_menu',
        'displayCond' => 'FIELD:is_siteroot:REQ:false',
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
];

$GLOBALS['TCA']['pages']['palettes']['page'] = [
    'displayCond' => 'FIELD:is_siteroot:REQ:true',
    'showitem' => '
        tx_das_logo,
        tx_das_bstheme,
        tx_das_navigationlevels,
        tx_das_searchpageuid,
        tx_das_structureddata,
        tx_das_showlanguageselector,
        tx_das_showpagetitle,
        tx_das_breadcrumb,
        tx_das_breadcrumbseparator
    '
];

ExtensionManagementUtility::addTCAcolumns(
    'pages',
    $tempColumns
);

ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'layout',
    'tx_das_megamenu',
    'after:newUntil'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;' . $languageFilePrefix . 'site_configuration,
        --palette--;;page,
        --palette--;;html_header,
        --palette--;;page_header
    '
);
