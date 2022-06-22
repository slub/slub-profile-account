<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Form\Element;

use Slub\SlubProfileAccount\Service\AccountService;
use Slub\SlubProfileAccount\Service\UserService;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Backend\Form\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UserCategoryDescriptionElement extends AbstractFormElement
{
    /**
     * @return array
     * @throws Exception
     */
    public function render(): array
    {
        $account = $this->getAccount((int)$this->data['databaseRow']['account_id']);
        $user = $this->getUser($account);
        $options = [
            'renderType' => 'input',
            'parameterArray' => [
                'itemFormElValue' => $user['X_category_desc'],
                'fieldConf' => [
                    'config' => [
                        'readOnly' => true
                    ]
                ]
            ]
        ];

        return $this->nodeFactory->create($options)->render();
    }

    /**
     * @param int $accountId
     * @return array
     */
    protected function getAccount(int $accountId): array
    {
        /** @var AccountService $accountService */
        $accountService = GeneralUtility::makeInstance(AccountService::class);

        return $accountService->getAccountById($accountId) ?? [];
    }

    /**
     * @param array $account
     * @return array
     */
    protected function getUser(array $account): array
    {
        /** @var UserService $userService */
        $userService = GeneralUtility::makeInstance(UserService::class);

        return $userService->getUserByAccount($account);
    }
}
