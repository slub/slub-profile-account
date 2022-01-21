<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use JsonException;
use Slub\SlubProfileAccount\Domain\Model\SearchQuery;
use Slub\SlubProfileAccount\Domain\Model\User\SearchQuery as User;
use Slub\SlubProfileAccount\Domain\Repository\SearchQueryRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SearchQueryService
{
    protected SearchQueryRepository $searchQueryRepository;

    /**
     * @param SearchQueryRepository $searchQueryRepository
     */
    public function __construct(SearchQueryRepository $searchQueryRepository)
    {
        $this->searchQueryRepository = $searchQueryRepository;
    }

    /**
     * @param User $user
     * @return User
     */
    public function sortSearchQueryFromUser(User $user): User
    {
        $userUid = $userUid = $user->getUid();
        $userSearchQuery = $this->searchQueryRepository
            ->findByUserUid($userUid)
            ->toArray();

        if (count($userSearchQuery) > 0) {
            $user->removeAllSearchQuery();

            /** @var SearchQuery $searchQuery */
            foreach ($userSearchQuery as $searchQuery) {
                $user->attachSearchQuery($searchQuery);
            }
        }

        return $user;
    }

    /**
     * @param array $query
     * @return SearchQuery
     * @throws JsonException
     */
    public function setSearchQuery(array $query): SearchQuery
    {
        /** @var SearchQuery $searchQuery */
        $searchQuery = GeneralUtility::makeInstance(SearchQuery::class);
        $title = $this->createTitle($query['query']);

        $searchQuery->setTitle($title);
        $searchQuery->setDescription(trim($query['description']));
        $searchQuery->setType($query['type']);
        $searchQuery->setNumberOfResults((int)$query['numberOfResults']);
        $searchQuery->setQuery(json_encode($query['query'], JSON_THROW_ON_ERROR));

        return $searchQuery;
    }

    /**
     * @param array $query
     * @return string
     */
    public function createTitle(array $query): string
    {
        $titles = [];

        foreach ($query as $queryItem) {
            $titles[] = trim($queryItem['input']);
        }

        return implode(', ', $titles);
    }
}
