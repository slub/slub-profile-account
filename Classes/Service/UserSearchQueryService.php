<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Doctrine\DBAL\DBALException;
use JsonException;
use Slub\SlubProfileAccount\Domain\Model\User\SearchQuery as User;
use Slub\SlubProfileAccount\Domain\Repository\User\SearchQueryRepository as UserRepository;
use Slub\SlubProfileAccount\Utility\FileUtility;
use Slub\SlubProfileAccount\Utility\LanguageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class UserSearchQueryService
{
    protected AccountService $accountService;
    protected PersistenceManager $persistenceManager;
    protected SearchQueryService $searchQueryService;
    protected UserRepository $userRepository;

    /**
     * @param AccountService $accountService
     * @param PersistenceManager $persistenceManager
     * @param SearchQueryService $searchQueryService
     * @param UserRepository $userRepository
     */
    public function __construct(
        AccountService $accountService,
        PersistenceManager $persistenceManager,
        SearchQueryService $searchQueryService,
        UserRepository $userRepository
    ) {
        $this->accountService = $accountService;
        $this->searchQueryService = $searchQueryService;
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

        if ($accountId > 0 && is_array($accountData)) {
            $user = $this->findUser($accountId);
        }

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws JsonException
     * @throws DBALException
     */
    public function updateUser(User $user): User
    {
        $data = FileUtility::getContent();

        if (isset($data['searchQuery']['query']) && count($data['searchQuery']['query']) > 0) {
            $this->updateSearchQuery($user, $data['searchQuery']);
        }

        if (isset($data['searchQuery']['delete']) && count($data['searchQuery']['delete']) > 0) {
            $this->deleteSearchQuery($user, $data['searchQuery']['delete']);
        }

        return $this->findUser($user->getAccountId());
    }

    /**
     * @param User $user
     * @param array $deleteIds
     * @throws DBALException
     */
    protected function deleteSearchQuery(User $user, array $deleteIds): void
    {
        $userSearchQueryIds = $this->getUserSearchQueryIds($user);

        foreach ($deleteIds as $deleteId) {
            $hasUserSearchQueryUid = $this->searchQueryService->hasUserSearchQueryUid($userSearchQueryIds, (int)$deleteId);

            if ($hasUserSearchQueryUid === true) {
                $this->searchQueryService->hideSearchQuery((int)$deleteId);
            }
        }
    }

    /**
     * @param User $user
     * @param array $query
     * @throws IllegalObjectTypeException
     * @throws JsonException
     * @throws UnknownObjectException
     */
    protected function updateSearchQuery(User $user, array $query): void
    {
        $searchQuery = $this->searchQueryService->setSearchQuery($query);

        $user->attachSearchQuery($searchQuery);

        $this->userRepository->update($user);
        $this->persistenceManager->persistAll();
    }

    /**
     * @param User $user
     * @return array
     */
    protected function getUserSearchQueryIds(User $user): array
    {
        $queries = $user->getSearchQuery();
        $queryIds = [];

        if (count($queries) === 0) {
            return $queryIds;
        }

        foreach ($queries as $query) {
            $queryIds[] = $query->getUid();
        }

        return $queryIds;
    }

    /**
     * @param int $accountId
     * @return User
     * @throws IllegalObjectTypeException
     */
    protected function findUser(int $accountId): User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneByAccountId($accountId);

        if ($user instanceof User) {
            // The child objects like search query are not sorted by repository settings.
            // Ask the search query service to sort them
            $user = $this->searchQueryService->sortSearchQueryFromUser($user);
        } else {
            $user = $this->createUser($accountId);
        }

        return $user;
    }

    /**
     * @param int $accountId
     * @return User
     * @throws IllegalObjectTypeException
     */
    protected function createUser(int $accountId): User
    {
        /** @var User $user */
        $user = GeneralUtility::makeInstance(User::class);
        $user = LanguageUtility::setLanguageProperty($user);
        $user->setAccountId($accountId);

        $this->userRepository->add($user);
        $this->persistenceManager->persistAll();

        return $user;
    }
}
