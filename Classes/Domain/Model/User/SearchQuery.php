<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model\User;

use Slub\SlubProfileAccount\Domain\Model\SearchQuery as ModelSearchQuery;
use Slub\SlubProfileAccount\Domain\Model\User\Entity\AccountIdInterface;
use Slub\SlubProfileAccount\Domain\Model\User\Entity\AccountIdTrait;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class SearchQuery extends AbstractEntity implements AccountIdInterface
{
    use AccountIdTrait;

    /**
     * @Extbase\ORM\Lazy
     * @var ?ObjectStorage<ModelSearchQuery>
     */
    protected ?ObjectStorage $searchQuery = null;

    /**
     * SearchQuery constructor.
     */
    public function __construct()
    {
        $this->searchQuery = new ObjectStorage();
    }

    /**
     * @return ObjectStorage<ModelSearchQuery>
     */
    public function getSearchQuery(): ?ObjectStorage
    {
        return $this->searchQuery;
    }

    /**
     * @param ObjectStorage $searchQuery
     */
    public function setSearchQuery(ObjectStorage $searchQuery): void
    {
        $this->searchQuery = $searchQuery;
    }

    /**
     * @param ModelSearchQuery $searchQuery
     */
    public function attachSearchQuery(ModelSearchQuery $searchQuery): void
    {
        $this->searchQuery->attach($searchQuery);
    }

    /**
     * @param ModelSearchQuery $searchQuery
     */
    public function removeSearchQuery(ModelSearchQuery $searchQuery): void
    {
        $this->searchQuery->detach($searchQuery);
    }

    public function removeAllSearchQuery(): void
    {
        $this->searchQuery = new ObjectStorage();
    }
}
