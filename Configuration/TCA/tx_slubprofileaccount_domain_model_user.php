<?php
defined('TYPO3_MODE') || die();

$ll = [
    'core' => [
        'tabs' => 'LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf',
        'general' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf'
    ],
    'frontend' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf',
    'slubProfileAccount' => [
        'db' => 'LLL:EXT:slub_profile_account/Resources/Private/Language/locallang_db.xlf',
        'tca' => 'LLL:EXT:slub_profile_account/Resources/Private/Language/locallang_tca.xlf'
    ]

    /*
     *
                    --palette--;' . $ll['slubProfileAccount']['tca'] . ':palette.hidden;hidden,
                    --palette--;' . $ll['slubProfileAccount']['tca'] . ':palette.access;access,
     */
];

return [
    'ctrl' => [
        'title' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_user',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'sortby' => 'title',
        'default_sortby' => 'title',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group'
        ],
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'descriptionColumn' => 'description',
        'editlock' => 'editlock',
        'translationSource' => 'l10n_source',
        'origUid' => 't3_origuid',
        'versioningWS' => true,
        'searchFields' => 'uid,title',
        'typeicon_classes' => [
            'default' => 'slubprofileaccount-model-user'
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;' . $ll['core']['tabs'] . ':general,
                    title,
                --div--;' . $ll['core']['tabs'] . ':language,
                    --palette--;;language,
                --div--;' . $ll['core']['tabs'] . ':access,
                    --palette--;;hidden,
                    --palette--;;access,
                --div--;' . $ll['core']['tabs'] . ':extended'
        ]
    ],
    'palettes' => [
        'access' => [
            'label' => $ll['frontend'] . ':palette.access',
            'showitem' => '
                starttime;' . $ll['frontend'] . ':starttime_formlabel,
                endtime;' . $ll['frontend'] . ':endtime_formlabel
            ',
        ],
        'hidden' => [
            'showitem' => '
                hidden;' . $ll['frontend'] . ':field.default.hidden
            ',
        ],
        'language' => [
            'showitem' => '
                sys_language_uid;' . $ll['frontend'] . ':sys_language_uid_formlabel,
                l18n_parent
            ',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $ll['core']['general'] . ':LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    [$ll['core']['general'] . ':LGL.allLanguages', -1],
                    [$ll['core']['general'] . ':LGL.default_value', 0]
                ],
                'default' => 0,
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ]
        ],
        'l18n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => $ll['core']['general'] . ':LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0]
                ],
                'foreign_table' => 'tx_slubprofileaccount_domain_model_user',
                'foreign_table_where' => 'AND tx_slubprofileaccount_domain_model_user.pid=###CURRENT_PID### AND tx_slubprofileaccount_domain_model_user.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => $ll['core']['general'] . ':LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ]
            ]
        ],
        'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => $ll['frontend'] . ':starttime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => $ll['frontend'] . ':endtime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ],
        'sorting' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'title' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'l10n_cat' => 'text',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_user.title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'unique,trim,required'
            ]
        ],
    ]
];
