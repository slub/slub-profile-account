<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model;

use DateTime;
use Slub\SlubProfileAccount\Domain\Model\User\Account as User;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class SearchQuery extends AbstractEntity
{
    protected ?DateTime $creationDate = null;
    protected string $title = '';
    protected string $description = '';
    protected string $type = '';
    protected string $query = '';
    protected int $numberOfResults = 0;
    /**
     * @Extbase\ORM\Lazy
     * @var ?ObjectStorage<User>
     */
    protected ?ObjectStorage $user = null;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->user = new ObjectStorage();
    }

    /**
     * @return DateTime $creationDate
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     */
    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

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

    /**
     * @return ObjectStorage<User>
     */
    public function getUser(): ?ObjectStorage
    {
        return $this->user;
    }

    /**
     * @param ObjectStorage $user
     */
    public function setUser(ObjectStorage $user): void
    {
        $this->user = $user;
    }

    /**
     * @param User $user
     */
    public function attachUser(User $user): void
    {
        $this->user->attach($user);
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user): void
    {
        $this->user->detach($user);
    }
}
