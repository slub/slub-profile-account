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
use Slub\SlubProfileAccount\Utility\FileUtility;
use Slub\SlubProfileAccount\Utility\SettingsUtility;
use Slub\SlubProfileAccount\Validation\ReserveArgumentValidation;

class UserReserveService
{
    protected ApiConfiguration $apiConfiguration;
    protected AccountService $accountService;
    protected ReserveArgumentValidation $reserveArgumentValidation;
    protected Request $request;
    protected int $itemsPerPage;

    /**
     * @param ApiConfiguration $apiConfiguration
     * @param AccountService $accountService
     * @param ReserveArgumentValidation $reserveArgumentValidation
     * @param Request $request
     */
    public function __construct(
        ApiConfiguration $apiConfiguration,
        AccountService $accountService,
        ReserveArgumentValidation $reserveArgumentValidation,
        Request $request
    ) {
        $this->apiConfiguration = $apiConfiguration;
        $this->accountService = $accountService;
        $this->reserveArgumentValidation = $reserveArgumentValidation;
        $this->request = $request;
        $this->itemsPerPage = (int)SettingsUtility::getPluginSettings()['general']['itemsPerPage'] ?? 25;
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getCurrent(array $arguments): ?array
    {
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        if ($accountId > 0 && is_array($account)) {
            $processed = $this->requestCurrent($accountId);

            return [
                'reserveCurrent' => $processed['reserve']
            ];
        }

        return [];
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getHistory(array $arguments): ?array
    {
        $page = (int)($arguments['page'] ?? 1);
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        if ($accountId > 0 && is_array($account)) {
            $processed = $this->requestHistory($accountId, $page);

            return [
                'paginator' => [
                    'countItems' => $processed['count'],
                    'currentPage' => $page,
                    'itemsPerPage' => $this->itemsPerPage
                ],
                'reserveHistory' => $processed['history']
            ];
        }

        return [];
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getDelete(array $arguments): ?array
    {
        $current = $this->getCurrent($arguments);

        if (count($current) === 0) {
            return [];
        }

        $data = FileUtility::getContent()['delete'];

        if ($data === null) {
            return ApiUtility::STATUS[400];
        }

        $validArguments = $this->reserveArgumentValidation->validateDeleteArguments($data, $current['reserveCurrent']);
        $accountId = $this->getAccountId($arguments);

        return $this->requestDelete($validArguments, $accountId);
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \JsonException
     */
    protected function requestCurrent(int $id): ?array
    {
        $uri = $this->apiConfiguration->getReserveCurrentUri();
        $uri = ApiUtility::replaceUriPlaceholder([$id], $uri);

        return $this->request->process($uri, 'GET', [
            'headers' => [
                'X-SLUB-Standard' => 'paia_ext',
                'X-SLUB-pretty' => '1',
                'X-SLUB-sort' => 'DESC'
            ]
        ]);
    }

    /**
     * @param array $data
     * @param int $accountId
     * @return array
     * @throws \JsonException
     */
    protected function requestDelete(array $data, int $accountId): array
    {
        if (count($data) === 0) {
            return [
                0 => ApiUtility::STATUS[415]
            ];
        }

        $uri = $this->apiConfiguration->getReserveDeleteUri();
        $results = [];

        foreach ($data as $item) {
            $label = $item['label'];
            $deleteUri = ApiUtility::replaceUriPlaceholder(
                [
                    $accountId,
                    '',
                    $label,
                    $item['queueNumber']
                ],
                $uri
            );
            $processed = $this->request->process($deleteUri, 'POST');

            if ($processed['status'] === 1) {
                $results[$label] = ApiUtility::STATUS[200];
            } else {
                $results[$label] = ApiUtility::STATUS[420];
                $results[$label]['error'] = $processed['message'];
            }
        }

        return $results;
    }

    /**
     * @param int $id
     * @param int $page
     * @return array|null
     * @throws \JsonException
     */
    protected function requestHistory(int $id, int $page): ?array
    {
        $uri = $this->apiConfiguration->getReserveHistoryUri();
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

    /**
     * @param array $arguments
     * @return int|null
     */
    protected function getAccountId(array $arguments): ?int
    {
        $account = $this->accountService->getAccountByArguments($arguments);
        $accountId = $this->accountService->getAccountId();

        if ($accountId > 0 && is_array($account)) {
            return $accountId;
        }

        return null;
    }
}
