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

class UserLoanHistoryService
{
    protected ApiConfiguration $apiConfiguration;
    protected AccountService $accountService;
    protected Request $request;

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
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getData(array $arguments): ?array
    {
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        if ($accountId > 0 && is_array($account)) {
            $processed = $this->requestData($accountId);
            $prepared = $this->prepareHistory($processed['history'] ?? []);

            return ['loanHistory' => $prepared];
        }

        return [];
    }

    /**
     * @param array $data
     * @return array
     */
    protected function prepareHistory(array $data): array
    {
        if (count($data) === 0) {
            return [];
        }

        krsort($data);

        // Set natural keys again
        return array_values($data);
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \JsonException
     */
    protected function requestData(int $id): ?array
    {
        $uri = $this->apiConfiguration->getLoanHistoryUri();
        $uri = ApiUtility::replaceUriPlaceholder([$id], $uri);

        return $this->request->process($uri, 'GET', [
            'headers' => [
                'X-SLUB-Standard' => 'paia_ext',
                'X-SLUB-pretty' => '1',
                'X-SLUB-sort' => 'ASC',
                //'X-SLUB-count' => '10',
                //'X-SLUB-offset' => 0
            ]
        ]);
    }
}
