<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Slub\SlubProfileAccount\Domain\Model\Dto\ApiConfiguration;
use Slub\SlubProfileAccount\Http\Request;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use Slub\SlubProfileAccount\Utility\SettingsUtility;

class UserLoanHistoryService
{
    protected ApiConfiguration $apiConfiguration;
    protected AccountService $accountService;
    protected Request $request;
    protected int $itemsPerPage;

    /**
     * @param ApiConfiguration $apiConfiguration
     * @param AccountService $accountService
     * @param Request $request
     */
    public function __construct(
        ApiConfiguration $apiConfiguration,
        AccountService $accountService,
        Request $request
    ) {
        $this->apiConfiguration = $apiConfiguration;
        $this->accountService = $accountService;
        $this->request = $request;
        $this->itemsPerPage = (int)SettingsUtility::getPluginSettings()['general']['itemsPerPage'] ?? 25;
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getData(array $arguments): ?array
    {
        $page = (int)($arguments['page'] ?? 1);
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        if ($accountId > 0 && is_array($account)) {
            $processed = $this->requestData($accountId, $page);

            return [
                'paginator' => [
                    'countItems' => $processed['count'],
                    'currentPage' => $page,
                    'itemsPerPage' => $this->itemsPerPage
                ],
                'loanHistory' => $processed['history']
            ];
        }

        return [];
    }

    /**
     * @param int $id
     * @param int $page
     * @return array|null
     * @throws \JsonException
     */
    protected function requestData(int $id, int $page): ?array
    {
        $uri = $this->apiConfiguration->getLoanHistoryUri();
        $uri = ApiUtility::replaceUriPlaceholder([$id], $uri);

        return $this->request->process($uri, 'GET', [
            'headers' => [
                'X-SLUB-Standard' => 'paia_ext',
                'X-SLUB-pretty' => '1',
                'X-SLUB-sort' => 'DESC',
                'X-SLUB-count' => $this->itemsPerPage,
                'X-SLUB-offset' => $this->getOffset($page)
            ]
        ]);
    }

    /**
     * @param int $page
     * @return int
     */
    protected function getOffset(int $page): int
    {
        return (int)($page * $this->itemsPerPage) - $this->itemsPerPage;
    }
}
