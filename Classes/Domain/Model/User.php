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

class User extends AbstractEntity
{
    protected int $accountId = 0;
    protected array $accountData = [];
    protected string $dashboardWidgets = '';

    /**
     * @return int $accountId
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     */
    public function setAccountId(int $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
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

    /**
     * @return string $dashboardWidgets
     */
    public function getDashboardWidgets(): string
    {
        return $this->dashboardWidgets;
    }

    /**
     * @param string $dashboardWidgets
     */
    public function setDashboardWidgets(string $dashboardWidgets): void
    {
        $this->dashboardWidgets = $dashboardWidgets;
    }
}
