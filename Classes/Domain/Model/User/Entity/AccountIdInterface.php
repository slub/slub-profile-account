<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model\User\Entity;

interface AccountIdInterface
{
    public function getAccountId(): int;

    /**
     * @param int $accountId
     */
    public function setAccountId(int $accountId): void;
}
