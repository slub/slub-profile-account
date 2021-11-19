<?php

use Slub\SlubProfileAccount\Controller\AccountController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

// Add tsconfig page
ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_account/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - event list
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'AccountDetail',
    [
        AccountController::class => 'detail'
    ],
    [
        AccountController::class => 'detail'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
