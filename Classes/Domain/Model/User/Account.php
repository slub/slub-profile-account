<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model\User;

use Slub\SlubProfileAccount\Domain\Model\User\Entity\AccountIdInterface;
use Slub\SlubProfileAccount\Domain\Model\User\Entity\AccountIdTrait;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Account extends AbstractEntity implements AccountIdInterface
{
    use AccountIdTrait;

    protected array $accountData = [];

    /**
     * You have to set the data first to get something. They are not stored in the database.
     *
     * @return array $accountData
     */
    public function getAccountData(): array
    {
        return $this->accountData;
    }

    /**
     * @param array $accountData
     */
    public function setAccountData(array $accountData): void
    {
        $this->accountData = $accountData;
    }
}
