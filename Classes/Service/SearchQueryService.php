<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Slub\SlubProfileAccount\Domain\Model\SearchQuery;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SearchQueryService
{
    /**
     * @param array $query
     * @return SearchQuery
     * @throws \JsonException
     */
    public function setSearchQuery(array $query): SearchQuery
    {
        /** @var SearchQuery $searchQuery */
        $searchQuery = GeneralUtility::makeInstance(SearchQuery::class);
        $title = $this->getTitle($query['query']);

        $searchQuery->setType($query['type']);
        $searchQuery->setNumberOfResults((int)$query['numberOfResults']);
        $searchQuery->setQuery(json_encode($query['query'], JSON_THROW_ON_ERROR));
        $searchQuery->setTitle($title);

        return $searchQuery;
    }

    /**
     * @param array $query
     * @return string
     */
    public function getTitle(array $query): string
    {
        $titles = [];

        foreach ($query as $queryItem) {
            $titles[] = $queryItem['input'];
        }

        return implode(', ', $titles);
    }
}
