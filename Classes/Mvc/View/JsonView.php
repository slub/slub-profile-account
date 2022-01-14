<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Mvc\View;

use Slub\SlubProfileAccount\Domain\Model\User\Dashboard;
use TYPO3\CMS\Extbase\Mvc\View\JsonView as ExtbaseJsonView;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class JsonView extends ExtbaseJsonView
{
    /**
     * The rendering configuration for this JSON view which
     * determines which properties of each variable to render.
     * In default all data are given.
     *
     * You can exclude fields like:
     *
     * 'account' => [
     *     '_descendAll' => [
     *         '_exclude' => [
     *             'categories',
     *             'contact',
     *             'discipline'
     *         ]
     *     ]
     * ]
     */
    protected array $accountConfiguration = [
        'userAccountDetail' => [
            '_only' => [
                'accountData'
            ],
            '_descend' => [
                'accountData' => []
            ]
        ],
        'userDashboardDetail' => [
            '_only' => [
                'dashboardWidgets'
            ]
        ],
        'status' => [
        ],
    ];

    public function __construct()
    {
        $this->setConfiguration($this->accountConfiguration);
    }
}
