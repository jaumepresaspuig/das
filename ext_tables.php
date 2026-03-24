<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['das'] = 'EXT:das/Resources/Public/Css/backend.css';

$renderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
$renderer->addJsFile('EXT:das/Resources/Public/JavaScript/backend.js', '', false, false, '', false, '|', false, '');
