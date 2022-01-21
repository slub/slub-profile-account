<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class SearchQueryRepository extends Repository
{
    protected $defaultOrderings = [
        'creationDate' => QueryInterface::ORDER_DESCENDING
    ];

    /**
     * @param array $uid
     * @return object
     */
    public function findByUserUid($uid = []): object
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('user.uid', $uid)
        );

        return $query->execute();
    }
}
