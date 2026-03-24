<?php

defined('TYPO3') or die();

if (empty($GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['das'])) {
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['das'] = 'EXT:das/Configuration/RTE/das.yaml';
}

FluidTYPO3\Flux\Core::registerProviderExtensionKey('das', 'Content');

\FluidTYPO3\Flux\Utility\CompatibilityRegistry::register(
    \FluidTYPO3\Flux\Builder\ContentTypeBuilder::DEFAULT_SHOWITEM,
    [
        '10.4.0' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
            --palette--;LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:pages.fontawesome;fontawesome,
        --div--;LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:configuration,
            pi_flexform,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --palette--;LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:bg;bg,
            --palette--;LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:custom_classes_and_styles;custom_classes_and_styles,
            --palette--;LLL:EXT:das/Resources/Private/Language/locallang_be.xlf:visibility;visibility,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories, 
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription'
    ]
);
