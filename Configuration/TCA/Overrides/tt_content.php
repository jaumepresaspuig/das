<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$languageFilePrefix = 'LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:';
$imgPath = 'EXT:das/Resources/Public/Images/';

$tempColumns = [
    'tx_das_htmlinheader' => [
        'displayCond' => 'FIELD:CType:=:html',
        'label' => $languageFilePrefix . 'html_in_header',
        'description' => $languageFilePrefix . 'html_in_header.description',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_galleryanimate' => [
        'label' => $languageFilePrefix . 'gallery_animate',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_hidecaption' => [
        'label' => $languageFilePrefix . 'hide_caption',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_stylemenu' => [
        'displayCond' => [
            'OR' => [
                'FIELD:CType:=:menu_abstract',
                'FIELD:CType:=:menu_categorized_content',
                'FIELD:CType:=:menu_categorized_pages',
                'FIELD:CType:=:menu_pages',
                'FIELD:CType:=:menu_recently_updated',
                'FIELD:CType:=:menu_related_pages',
                'FIELD:CType:=:menu_section',
                'FIELD:CType:=:menu_section_pages',
                'FIELD:CType:=:menu_sitemap',
                'FIELD:CType:=:menu_sitemap_pages',
                'FIELD:CType:=:menu_subpages'
            ]
        ],
        'label' => $languageFilePrefix . 'style_menu',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_order1' => [
        'displayCond' => 'FIELD:imageorient:=:25',
        'label' => $languageFilePrefix . 'gallery_order1',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_pagegallery' => [
        'displayCond' => [
            'AND' => [
                'FIELD:CType:=:textmedia',
                'FIELD:image_zoom:=:1'
            ]
        ],
        'label' => $languageFilePrefix . 'page_gallery',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_customclasses' => [
        'label' => $languageFilePrefix . 'custom_classes',
        'config' => [
            'type' => 'input',
            'size' => '80'
        ]
    ],
    'tx_das_customstyles' => [
        'label' => $languageFilePrefix . 'custom_styles',
        'config' => [
            'type' => 'text',
            'rows' => 3
        ]
    ],
    'tx_das_dropshadow' => [
        'label' => $languageFilePrefix . 'drop_shadow',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'none',
                    'value' => '0',
                    'icon' => $imgPath . 'Dropshadow/dropshadow_0.png'
                ],
                [
                    'label' => $languageFilePrefix . 'small',
                    'value' => '1',
                    'icon' => $imgPath. 'Dropshadow/dropshadow_1.png'
                ],
                [
                    'label' => $languageFilePrefix . 'normal',
                    'value' => '2',
                    'icon' => $imgPath . 'Dropshadow/dropshadow_2.png'
                ],
                [
                    'label' => $languageFilePrefix . 'large',
                    'value' => '3',
                    'icon' => $imgPath . 'Dropshadow/dropshadow_3.png'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '0',
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ]
    ],
    'tx_das_visibility' => [
        'label' => $languageFilePrefix . 'responsive',
        'config' => [
            'type' => 'check',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'hidden.xs',
                    'value' => 'xs'
                ],
                [
                    'label' => $languageFilePrefix . 'hidden.sm',
                    'value' => 'sm'
                ],
                [
                    'label' => $languageFilePrefix . 'hidden.md',
                    'value' => 'md'
                ],
                [
                    'label' => $languageFilePrefix . 'hidden.lg',
                    'value' => 'lg'
                ],
                [
                    'label' => $languageFilePrefix . 'hidden.xl',
                    'value' => 'xl'
                ]
            ],
            'cols' => 'inline',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_bgpredefinedcolor' => [
        'label' => $languageFilePrefix . 'bg_predefined_color',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'none',
                    'value' => '',
                    'icon' => $imgPath . 'Colors/bg_none.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.primary',
                    'value' => 'bg-primary',
                    'icon' => $imgPath . 'Colors/bg_primary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.secondary',
                    'value' => 'bg-secondary',
                    'icon' => $imgPath . 'Colors/bg_secondary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.success',
                    'value' => 'bg-success',
                    'icon' => $imgPath . 'Colors/bg_success.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.danger',
                    'value' => 'bg-danger',
                    'icon' => $imgPath . 'Colors/bg_danger.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.warning',
                    'value' => 'bg-warning',
                    'icon' => $imgPath . 'Colors/bg_warning.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.info',
                    'value' => 'bg-info',
                    'icon' => $imgPath . 'Colors/bg_info.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.light',
                    'value' => 'bg-light',
                    'icon' => $imgPath . 'Colors/bg_light.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.dark',
                    'value' => 'bg-dark',
                    'icon' => $imgPath . 'Colors/bg_dark.svg'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '',
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ]
    ],
    'tx_das_bgcolor' => [
        'label' => $languageFilePrefix . 'bg_color',
        'description' => $languageFilePrefix . 'bg_color.description',
        'config' => [
            'type' => 'color',
            'size' => 10,
            'eval' => 'trim'
        ]
    ],
    'tx_das_bgimage' => [
        'label' => $languageFilePrefix . 'bg_image',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'jpg,jpeg,png,gif,webp,youtube,vimeo,mp4',
            'appearance' => [
                'fileUploadAllowed' => 0
            ]
        ],
        'onChange' => 'reload',
    ],
    'tx_das_bgoverlay' => [
        'displayCond' => 'FIELD:tx_das_bgimage:=:1',
        'label' => $languageFilePrefix . 'bg_overlay',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'none',
                    'value' => '',
                    'icon' => $imgPath . 'Colors/bg_none.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.primary',
                    'value' => 'bg-primary',
                    'icon' => $imgPath . 'Colors/bg_primary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.secondary',
                    'value' => 'bg-secondary',
                    'icon' => $imgPath . 'Colors/bg_secondary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.success',
                    'value' => 'bg-success',
                    'icon' => $imgPath . 'Colors/bg_success.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.danger',
                    'value' => 'bg-danger',
                    'icon' => $imgPath . 'Colors/bg_danger.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.warning',
                    'value' => 'bg-warning',
                    'icon' => $imgPath . 'Colors/bg_warning.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.info',
                    'value' => 'bg-info',
                    'icon' => $imgPath . 'Colors/bg_info.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.light',
                    'value' => 'bg-light',
                    'icon' => $imgPath . 'Colors/bg_light.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.dark',
                    'value' => 'bg-dark',
                    'icon' => $imgPath . 'Colors/bg_dark.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.blur',
                    'value' => 'bg-blur',
                    'icon' => $imgPath . 'Colors/bg_none.svg'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '',
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ],
        'onChange' => 'reload',
    ],
    'tx_das_bgoverlayvignete' => [
        'displayCond' => [
            'AND' => [
                'FIELD:tx_das_bgimage:=:1',
                'FIELD:tx_das_bgoverlay:!=:',
                'FIELD:tx_das_bgoverlay:!=:bg-blur',
            ],
        ],
        'label' => $languageFilePrefix . 'bg_overlayvignete',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_fixedbg' => [
        'displayCond' => 'FIELD:tx_das_bgimage:=:1',
        'label' => $languageFilePrefix . 'fixed_bg',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle'
        ]
    ],
    'tx_das_textcolor' => [
        'label' => $languageFilePrefix . 'text_color',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'default',
                    'value' => ''
                ],
                [
                    'label' => $languageFilePrefix . 'black',
                    'value' => 'text-black'
                ],
                [
                    'label' => $languageFilePrefix . 'white',
                    'value' => 'text-white'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1
        ]
    ],
    'tx_das_gallerywidth' => [
        'label' => $languageFilePrefix . 'gallery_width',
        'displayCond' => 'FIELD:imageorient:>=:20',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '50%',
                    'value' =>  '6'
                ],
                [
                    'label' => '33%',
                    'value' =>  '4'
                ],
                [
                    'label' => '25%',
                    'value' =>  '3'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '4',
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ]
    ],
    'tx_das_imageratio' => [
        'label' => $languageFilePrefix . 'image_ratio',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'image_ratio.original',
                    'value' =>  ''
                ],
                [
                    'label' => '16:9',
                    'value' =>  '16x9'
                ],
                [
                    'label' => '4:3',
                    'value' =>  '4x3'
                ],
                [
                    'label' => '1:1',
                    'value' =>  '1x1'
                ],
                [
                    'label' => '3:4',
                    'value' =>  '3x4'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '4x3',
        ]
    ],
    'tx_das_columns' => [
        'label' => $languageFilePrefix . 'columns',
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
                ],
                [
                    'label' => '3',
                    'value' => '3'
                ],
                [
                    'label' => '4',
                    'value' => '4'
                ],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '1',
        ]
    ],
    'tx_das_faicon' => [
        'displayCond' => 'FIELD:CType:!=:html',
        'label' => $languageFilePrefix . 'pages.fontawesome.icon',
        'description' => $languageFilePrefix . 'pages.fontawesome.icon.description',
        'config' => [
            'type' => 'input',
            'size' => 10
        ]
    ],
    'tx_das_fasize' => [
        'displayCond' => 'FIELD:CType:!=:html',
        'label' => $languageFilePrefix . 'pages.fontawesome.size',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '50%',
                    'value' => '0.5'
                ],
                [
                    'label' => '75%',
                    'value' => '0.75'
                ],
                [
                    'label' => '100%',
                    'value' => '1'
                ],
                [
                    'label' => '125%',
                    'value' => '1.25'
                ],
                [
                    'label' => '150%',
                    'value' => '1.5'
                ],
                [
                    'label' => '175%',
                    'value' => '1.75'
                ],
                [
                    'label' => '200%',
                    'value' => '2'
                ]
            ],
            'default' => '1',
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1
        ]
    ],
    'tx_das_fapredefinedcolor' => [
        'displayCond' => 'FIELD:CType:!=:html',
        'label' => $languageFilePrefix . 'pages.fontawesome.predefined_color',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'none',
                    'value' => '',
                    'icon' => $imgPath . 'Colors/bg_none.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.primary',
                    'value' => 'text-primary',
                    'icon' => $imgPath . 'Colors/bg_primary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.secondary',
                    'value' => 'text-secondary',
                    'icon' => $imgPath . 'Colors/bg_secondary.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.success',
                    'value' => 'text-success',
                    'icon' => $imgPath . 'Colors/bg_success.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.danger',
                    'value' => 'text-danger',
                    'icon' => $imgPath . 'Colors/bg_danger.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.warning',
                    'value' => 'text-warning',
                    'icon' => $imgPath . 'Colors/bg_warning.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.info',
                    'value' => 'text-info',
                    'icon' => $imgPath . 'Colors/bg_info.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.light',
                    'value' => 'text-light',
                    'icon' => $imgPath . 'Colors/bg_light.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'colors.dark',
                    'value' => 'text-dark',
                    'icon' => $imgPath . 'Colors/bg_dark.svg'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '',
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ]
    ],
    'tx_das_facolor' => [
        'displayCond' => 'FIELD:CType:!=:html',
        'label' => $languageFilePrefix . 'pages.fontawesome.color',
        'description' => $languageFilePrefix . 'pages.fontawesome.color.description',
        'config' => [
            'type' => 'color',
            'size' => 10,
            'eval' => 'trim',
        ]
    ],
    'tx_das_faposition' => [
        'displayCond' => 'FIELD:CType:!=:html',
        'label' => $languageFilePrefix . 'pages.fontawesome.position',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $languageFilePrefix . 'left',
                    'value' => 'left',
                    'icon' => $imgPath . 'FA/fa_left.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'top',
                    'value' => 'top',
                    'icon' => $imgPath . 'FA/fa_top.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'right',
                    'value' => 'right',
                    'icon' => $imgPath . 'FA/fa_right.svg'
                ],
                [
                    'label' => $languageFilePrefix . 'bottom',
                    'value' => 'bottom',
                    'icon' => $imgPath . 'FA/fa_bottom.svg'
                ]
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ]
        ]
    ],
    'tx_das_textincolumns' => [
        'displayCond' => 'FIELD:CType:=:textmedia',
        'label' => $languageFilePrefix . 'tt_content.textincolumns',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '',
                    'value' => '1'
                ],
                [
                    'label' => '2',
                    'value' => '2'
                ],
                [
                    'label' => '3',
                    'value' => '3'
                ],
                [
                    'label' => '4',
                    'value' => '4'
                ],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
            'default' => '1',
        ]
    ],
];

$GLOBALS['TCA']['tt_content']['palettes']['visibility'] = [
    'label' => $languageFilePrefix . 'visibility',
    'showitem' => '
        tx_das_visibility
    '
];

$GLOBALS['TCA']['tt_content']['palettes']['custom_classes_and_styles'] = [
    'label' => $languageFilePrefix . 'custom_classes_and_styles',
    'showitem' => '
        tx_das_textcolor,
        tx_das_customclasses,
        tx_das_customstyles
    '
];

$GLOBALS['TCA']['tt_content']['palettes']['bg'] = [
    'label' => $languageFilePrefix . 'bg',
    'showitem' => '
        tx_das_bgpredefinedcolor,
        tx_das_bgcolor,
        tx_das_bgimage,
        tx_das_bgoverlay,
        tx_das_bgoverlayvignete,
        tx_das_fixedbg
    '
];

$GLOBALS['TCA']['tt_content']['palettes']['fontawesome'] = [
    'label' => $languageFilePrefix . 'pages.fontawesome',
    'showitem' => '
        tx_das_faicon;' . $languageFilePrefix . 'pages.fontawesome.icon,
        tx_das_fasize;' . $languageFilePrefix . 'pages.fontawesome.size,
        tx_das_fapredefinedcolor;' . $languageFilePrefix . 'pages.fontawesome.predefined_color,
        tx_das_facolor;' . $languageFilePrefix . 'pages.fontawesome.color,
        tx_das_faposition;' . $languageFilePrefix . 'pages.fontawesome.position
    '
];

ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $tempColumns
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_das_htmlinheader',
    '',
    'after:bodytext'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'gallerySettings',
    'tx_das_gallerywidth',
    'after:imageorient'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'gallerySettings',
    'tx_das_imageratio',
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'gallerySettings',
    'tx_das_galleryanimate',
    'after:tx_das_imageratio'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'gallerySettings',
    'tx_das_hidecaption',
    ''
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'gallerySettings',
    'tx_das_order1',
    'after:tx_das_imageratio'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'uploadslayout',
    'tx_das_columns'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'frames',
    'tx_das_dropshadow'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'imagelinks',
    'tx_das_pagegallery'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;bg',
    '',
    'after:tx_das_dropshadow'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;custom_classes_and_styles',
    '',
    'after:tx_das_fixedbg'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;visibility',
    '',
    'after:tx_das_customstyles'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;fontawesome',
    '',
    'after:header'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_das_textincolumns',
    '',
    'after:bodytext'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_das_stylemenu',
    '',
    'after:tx_das_faposition'
);

$GLOBALS['TCA']['tt_content']['types']['textmedia']['columnsOverrides']['imageorient']['onChange'] = 'reload';
$GLOBALS['TCA']['tt_content']['types']['textmedia']['columnsOverrides']['image_zoom']['onChange'] = 'reload';

$TCA['tt_content']['columns']['header']['l10n_mode'] = '';
$TCA['tt_content']['columns']['bodytext']['l10n_mode'] = '';
