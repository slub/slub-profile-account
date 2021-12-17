<?php

use Slub\SlubProfileAccount\Controller\UserController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

// Add tsconfig page
ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_account/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - user detail
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserDetail',
    [
        UserController::class => 'detail'
    ],
    [
        UserController::class => 'detail'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user update
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserUpdate',
    [
        UserController::class => 'update'
    ],
    [
        UserController::class => 'update'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
