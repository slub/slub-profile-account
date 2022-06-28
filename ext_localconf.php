<?php

use Slub\SlubProfileAccount\Controller\UserAccountController;
use Slub\SlubProfileAccount\Controller\UserDashboardController;
use Slub\SlubProfileAccount\Controller\UserPasswordController;
use Slub\SlubProfileAccount\Controller\UserSearchQueryController;
use Slub\SlubProfileAccount\Form\Element\AccountOverviewElement;
use Slub\SlubProfileAccount\Form\Element\UserCategoryDescriptionElement;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

// Add tsconfig page
ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_account/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - useraccount detail
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

// Configure plugin - useraccount update
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserAccountUpdate',
    [
        UserAccountController::class => 'update'
    ],
    [
        UserAccountController::class => 'update'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user password update
ExtensionUtility::configurePlugin(
    'SlubProfileAccount',
    'UserPasswordUpdate',
    [
        UserPasswordController::class => 'update'
    ],
    [
        UserPasswordController::class => 'update'
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

// Register new renderTypes
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'] = [
    'accountOverview' => [
        'nodeName' => 'accountOverview',
        'priority' => 40,
        'class' => AccountOverviewElement::class,
    ],
    'userCategoryDescription' => [
        'nodeName' => 'userCategoryDescription',
        'priority' => 45,
        'class' => UserCategoryDescriptionElement::class,
    ]
];

// Custom cache to save user account
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubprofileaccount_account'] ??= [];
