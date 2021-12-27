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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class UserAccountService
{
    protected AccountService $accountService;
    protected PersistenceManager $persistenceManager;
    protected UserRepository $userRepository;

    /**
     * @param AccountService $accountService
     * @param PersistenceManager $persistenceManager
     * @param UserRepository $userRepository
     */
    public function __construct(
        AccountService $accountService,
        PersistenceManager $persistenceManager,
        UserRepository $userRepository
    ) {
        $this->accountService = $accountService;
        $this->persistenceManager = $persistenceManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $arguments
     * @return User|null
     * @throws IllegalObjectTypeException
     */
    public function getUser(array $arguments): ?User
    {
        $user = null;

        $accountData = $this->accountService->getAccountDataByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        ($accountId === 0) ?: $user = $this->findUser($accountId);
        $user === null ?: $user->setAccountData($accountData);

        return $user;
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
        $userAccount instanceof User ?: $userAccount = $this->createUser($accountId);

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
        $userAccount->setAccountId($accountId);

        $this->userRepository->add($userAccount);
        $this->persistenceManager->persistAll();

        return $userAccount;
    }
}
