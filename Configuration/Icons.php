<?php

defined('TYPO3') || die();

return [
    'slubprofileaccount-overlay-extension' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:slub_profile_account/Resources/Public/Icons/Overlay/extension.svg'
    ],
    'slubprofileaccount-model-user' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:slub_profile_account/Resources/Public/Icons/Model/user.svg'
    ],
    'slubprofileaccount-pagetree-userfolder' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:slub_profile_account/Resources/Public/Icons/PageTree/user-folder.svg'
    ],
    'slubprofileaccount-wizard-userdetail' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:slub_profile_account/Resources/Public/Icons/Wizard/user-detail.svg'
    ],
    'slubprofileaccount-wizard-userupdate' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:slub_profile_account/Resources/Public/Icons/Wizard/user-update.svg'
    ],
];
