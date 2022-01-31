<?php

defined('TYPO3') || die();

return [
    \Slub\SlubProfileAccount\Domain\Model\SearchQuery::class => [
        'tableName' => 'tx_slubprofileaccount_domain_model_searchquery',
        'properties' => [
            'creationDate' => [
                'fieldName' => 'crdate',
            ],
        ],
    ],
    \Slub\SlubProfileAccount\Domain\Model\User\Account::class => [
        'tableName' => 'tx_slubprofileaccount_domain_model_user',
    ],
    \Slub\SlubProfileAccount\Domain\Model\User\Dashboard::class => [
        'tableName' => 'tx_slubprofileaccount_domain_model_user',
    ],
    \Slub\SlubProfileAccount\Domain\Model\User\SearchQuery::class => [
        'tableName' => 'tx_slubprofileaccount_domain_model_user',
    ]
];
