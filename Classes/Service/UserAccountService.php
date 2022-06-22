<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Slub\SlubProfileAccount\Domain\Model\User\Account as User;
use Slub\SlubProfileAccount\Domain\Repository\User\AccountRepository as UserRepository;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use Slub\SlubProfileAccount\Utility\FileUtility;
use Slub\SlubProfileAccount\Utility\LanguageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class UserAccountService
{
    protected AccountService $accountService;
    protected PersistenceManager $persistenceManager;
    protected UserService $userService;
    protected UserRepository $userRepository;

    /**
     * @param AccountService $accountService
     * @param PersistenceManager $persistenceManager
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(
        AccountService $accountService,
        PersistenceManager $persistenceManager,
        UserService $userService,
        UserRepository $userRepository
    ) {
        $this->accountService = $accountService;
        $this->persistenceManager = $persistenceManager;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $arguments
     * @return User|null
     * @throws IllegalObjectTypeException
     */
    public function getUser(array $arguments): ?User
    {
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();
        $userProfile = $this->userService->getUserByAccount($account);
        $user = null;

        if ($accountId > 0 && is_array($account)) {
            $user = $this->findUser($accountId);
        }

        if ($user instanceof User) {
            $user->setAccount($account);
            $user->setUser($userProfile);
        }

        return $user;
    }

    /**
     * @param User $user
     * @return array
     * @throws \JsonException
     */
    public function updateUser(User $user): array
    {
        $accountId = $user->getAccountId();
        $data = FileUtility::getContent()['account'];

        if ($data === null) {
            return ApiUtility::STATUS[400];
        }

        $updateStatus = $this->accountService->updateAccount($accountId, $data);

        if ($updateStatus['code'] === 200) {
            $this->accountService->flushCache($accountId);
        }

        return $updateStatus;
    }

    /**
     * @param int $accountId
     * @return User
     * @throws IllegalObjectTypeException
     */
    protected function findUser(int $accountId): User
    {
        /** @var User|null $userAccount */
        $userAccount = $this->userRepository->findOneByAccountId($accountId);

        if ($userAccount === null) {
            $userAccount = $this->createUser($accountId);
        }

        return $userAccount;
    }

    /**
     * @param int $accountId
     * @return User
     * @throws IllegalObjectTypeException
     */
    protected function createUser(int $accountId): User
    {
        /** @var User $userAccount */
        $userAccount = GeneralUtility::makeInstance(User::class);
        $userAccount = LanguageUtility::setLanguageProperty($userAccount);
        $userAccount->setAccountId($accountId);

        $this->userRepository->add($userAccount);
        $this->persistenceManager->persistAll();

        return $userAccount;
    }
}
