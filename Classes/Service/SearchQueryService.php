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
use PDO;
use Slub\SlubProfileAccount\Domain\Model\SearchQuery;
use Slub\SlubProfileAccount\Domain\Model\User\SearchQuery as User;
use Slub\SlubProfileAccount\Domain\Repository\SearchQueryRepository;
use Slub\SlubProfileAccount\Utility\LanguageUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SearchQueryService
{
    protected const TABLE = 'tx_slubprofileaccount_domain_model_searchquery';
    protected ConnectionPool $connectionPool;
    protected SearchQueryRepository $searchQueryRepository;

    /**
     * @param ConnectionPool $connectionPool
     * @param SearchQueryRepository $searchQueryRepository
     */
    public function __construct(
        ConnectionPool $connectionPool,
        SearchQueryRepository $searchQueryRepository
    ) {
        $this->connectionPool = $connectionPool;
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
     * @param int $uid
     * @throws DBALException
     */
    public function hideSearchQuery(int $uid): void
    {
        $queryBuilder = $this->getQueryBuilder(self::TABLE);
        $queryBuilder
            ->update(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($uid, PDO::PARAM_INT)
                )
            )
            ->set('hidden', 1)
            ->executeStatement();
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
        $searchQuery = LanguageUtility::setLanguageProperty($searchQuery);

        $title = $this->createTitle($query['query']);

        $searchQuery->setTitle($title);
        $searchQuery->setDescription(trim($query['description']));
        $searchQuery->setType($query['type']);
        $searchQuery->setNumberOfResults((int)$query['numberOfResults']);
        $searchQuery->setQuery(json_encode($query['query'], JSON_THROW_ON_ERROR));

        return $searchQuery;
    }

    /**
     * @param array $userSearchQueryIds
     * @param int $searchQueryUid
     * @return bool
     */
    public function hasUserSearchQueryUid(array $userSearchQueryIds, int $searchQueryUid): bool
    {
        return in_array($searchQueryUid, $userSearchQueryIds, true);
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

    /**
     * @param string $table
     * @return QueryBuilder
     */
    protected function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
