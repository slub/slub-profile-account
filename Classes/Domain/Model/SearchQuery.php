<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class SearchQuery extends AbstractEntity
{
    protected string $title = '';
    protected string $description = '';
    protected string $type = '';
    protected string $query = '';
    protected int $user = 0;
    protected int $numberOfResults = 0;

    /**
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string $type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string $query
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return int $user
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * @return int $numberOfResults
     */
    public function getNumberOfResults(): int
    {
        return $this->numberOfResults;
    }

    /**
     * @param int $numberOfResults
     */
    public function setNumberOfResults(int $numberOfResults): void
    {
        $this->numberOfResults = $numberOfResults;
    }
}
