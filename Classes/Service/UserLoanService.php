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
use Slub\SlubProfileAccount\Validation\LoanArgumentValidation;

class UserLoanService
{
    protected ApiConfiguration $apiConfiguration;
    protected AccountService $accountService;
    protected LoanArgumentValidation $loanArgumentValidation;
    protected Request $request;
    protected int $itemsPerPage;

    /**
     * @param ApiConfiguration $apiConfiguration
     * @param AccountService $accountService
     * @param LoanArgumentValidation $loanArgumentValidation
     * @param Request $request
     */
    public function __construct(
        ApiConfiguration $apiConfiguration,
        AccountService $accountService,
        LoanArgumentValidation $loanArgumentValidation,
        Request $request
    ) {
        $this->apiConfiguration = $apiConfiguration;
        $this->accountService = $accountService;
        $this->loanArgumentValidation = $loanArgumentValidation;
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
        $accountId = $this->getAccountId($arguments);

        if ($accountId === null) {
            return [];
        }

        $processed = $this->requestCurrent($accountId);

        return [
            'loanCurrent' => $processed['loan']
        ];
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getHistory(array $arguments): ?array
    {
        $accountId = $this->getAccountId($arguments);

        if ($accountId === null) {
            return [];
        }

        $page = (int)($arguments['page'] ?? 1);
        $processed = $this->requestHistory($accountId, $page);

        return [
            'paginator' => [
                'countItems' => $processed['count'],
                'currentPage' => $page,
                'itemsPerPage' => $this->itemsPerPage
            ],
            'loanHistory' => $processed['history']
        ];
    }

    /**
     * @param array $arguments
     * @return array|null
     * @throws \JsonException
     */
    public function getRenewal(array $arguments): ?array
    {
        $current = $this->getCurrent($arguments);

        if (count($current) === 0) {
            return [];
        }

        $data = FileUtility::getContent()['renew'];

        if ($data === null) {
            return ApiUtility::STATUS[400];
        }

        $validArguments = $this->loanArgumentValidation->validateRenewalArguments($data, $current['loanCurrent']);
        $accountId = $this->getAccountId($arguments);

        return $this->requestRenewal($validArguments['barcodes'], $accountId);
    }

    /**
     * @param array $barcodes
     * @param int $accountId
     * @return array
     * @throws \JsonException
     */
    protected function requestRenewal(array $barcodes, int $accountId): array
    {
        if (count($barcodes) === 0) {
            return [
                0 => ApiUtility::STATUS[405]
            ];
        }

        $uri = $this->apiConfiguration->getLoanRenewalUri();
        $results = [];

        foreach ($barcodes as $barcode) {
            $renewalUri = ApiUtility::replaceUriPlaceholder([$accountId, $barcode], $uri);
            $processed = $this->request->process($renewalUri, 'POST');

            if ($processed['status'] === 1) {
                $results[$barcode] = ApiUtility::STATUS[200];
            } else {
                $results[$barcode] = ApiUtility::STATUS[410];
                $results[$barcode]['error'] = $processed['message'];
            }
        }

        return $results;
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \JsonException
     */
    protected function requestCurrent(int $id): ?array
    {
        $uri = $this->apiConfiguration->getLoanCurrentUri();
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
     * @param int $id
     * @param int $page
     * @return array|null
     * @throws \JsonException
     */
    protected function requestHistory(int $id, int $page): ?array
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
