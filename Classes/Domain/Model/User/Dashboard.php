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

class Dashboard extends AbstractEntity implements AccountIdInterface
{
    use AccountIdTrait;

    protected string $dashboardWidgets = '';

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
