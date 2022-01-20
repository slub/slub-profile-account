<?php

defined('TYPO3_MODE') || die();

$ll = [
    'core' => [
        'general' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf',
        'tabs' => 'LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf',
        'tca' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf'
    ],
    'frontend' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf',
    'slubProfileAccount' => [
        'db' => 'LLL:EXT:slub_profile_account/Resources/Private/Language/locallang_db.xlf',
        'tabs' => 'LLL:EXT:slub_profile_account/Resources/Private/Language/locallang_tabs.xlf'
    ]
];

return [
    'ctrl' => [
        'title' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'editlock' => 'editlock',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group'
        ],
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'descriptionColumn' => 'description',
        'translationSource' => 'l10n_source',
        'origUid' => 't3_origuid',
        'versioningWS' => true,
        'searchFields' => 'title, description, type, query, number_of_results, user',
        'typeicon_classes' => [
            'default' => 'slubprofileaccount-model-searchquery'
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;' . $ll['core']['tabs'] . ':general,
                    title, description, user,
                --div--;' . $ll['slubProfileAccount']['tabs'] . ':search,
                    query, type, number_of_results,
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
                endtime;' . $ll['frontend'] . ':endtime_formlabel,
                --linebreak--,
                editlock
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
        'editlock' => [
            'exclude' => true,
            'displayCond' => 'HIDE_FOR_NON_ADMINS',
            'label' => $ll['core']['tca'] . ':editlock',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $ll['core']['general'] . ':LGL.language',
            'config' => [
                'type' => 'language'
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
                'foreign_table' => 'tx_slubprofileaccount_domain_model_searchquery',
                'foreign_table_where' => 'AND tx_slubprofileaccount_domain_model_searchquery.pid=###CURRENT_PID### AND tx_slubprofileaccount_domain_model_searchquery.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l18n_diffsource' => [
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
        'title' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ]
        ],
        'description' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 30,
                'eval' => 'trim',
            ]
        ],
        'type' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ]
        ],
        'query' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.query',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 30,
                'eval' => 'trim,required',
            ]
        ],
        'number_of_results' => [
            'exclude' => true,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.numberOfResults',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,int,required',
            ]
        ],
        'user' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => $ll['slubProfileAccount']['db'] . ':tx_slubprofileaccount_domain_model_searchquery.user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_field' => 'uid_foreign',
                'foreign_table' => 'tx_slubprofileaccount_domain_model_user',
                'foreign_table_where' => 'AND tx_slubprofileaccount_domain_model_user.sys_language_uid IN (-1,0) AND tx_slubprofileaccount_domain_model_user.pid=###CURRENT_PID### AND tx_slubprofileaccount_domain_model_user.deleted = 0',
                'MM' => 'tx_slubprofileaccount_domain_model_user_mm',
                'MM_match_fields' => [
                    'tablenames' => 'tx_slubprofileaccount_domain_model_searchquery'
                ],
                'MM_hasUidField' => 1,
                'MM_opposite_field' => 'search_query',
                'minitems' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
    ]
];
