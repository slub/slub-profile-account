<?php

use Slub\SlubProfileAccount\Controller\UserAccountController;
use Slub\SlubProfileAccount\Controller\UserDashboardController;
use Slub\SlubProfileAccount\Controller\UserSearchQueryController;
use Slub\SlubProfileAccount\Form\Element\AccountDataElement;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

// Add tsconfig page
ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_account/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - useraccount  detail
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserAccountDetail',
    [
        UserAccountController::class => 'detail'
    ],
    [
        UserAccountController::class => 'detail'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user dashboard detail
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserDashboardDetail',
    [
        UserDashboardController::class => 'detail'
    ],
    [
        UserDashboardController::class => 'detail'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user dashboard update
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserDashboardUpdate',
    [
        UserDashboardController::class => 'update'
    ],
    [
        UserDashboardController::class => 'update'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user search query detail
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserSearchQueryDetail',
    [
        UserSearchQueryController::class => 'detail'
    ],
    [
        UserSearchQueryController::class => 'detail'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user search query update
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserSearchQueryUpdate',
    [
        UserSearchQueryController::class => 'update'
    ],
    [
        UserSearchQueryController::class => 'update'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Register new renderType - accountData
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][time()] = [
    'nodeName' => 'accountData',
    'priority' => 40,
    'class' => AccountDataElement::class,
];

// Custom cache to save user account
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubprofileaccount_account'] ??= [];
