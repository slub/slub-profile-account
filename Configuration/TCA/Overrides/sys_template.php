<?php

defined('TYPO3') || die();

// Add static typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_profile_account',
    'Configuration/TypoScript/',
    'SLUB profile account'
);
