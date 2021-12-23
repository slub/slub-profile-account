<?php

use Slub\SlubProfileAccount\Controller\UserController;
use Slub\SlubProfileAccount\Form\Element\AccountDataElement;
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

// Register new renderType - accountData"
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][time()] = [
    'nodeName' => 'accountData',
    'priority' => 40,
    'class' => AccountDataElement::class,
];
