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
use Slub\SlubProfileAccount\Sanitization\AccountArgumentSanitization;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use Slub\SlubProfileEvents\Http\Request;

class AccountService
{
    protected AccountArgumentSanitization $accountArgumentSanitization;
    protected ApiConfiguration $apiConfiguration;
    protected Request $request;
    protected int $accountId;

    /**
     * @param AccountArgumentSanitization $accountArgumentSanitization
     * @param ApiConfiguration $apiConfiguration
     * @param Request $request
     */
    public function __construct(
        AccountArgumentSanitization $accountArgumentSanitization,
        ApiConfiguration $apiConfiguration,
        Request $request
    ) {
        $this->accountArgumentSanitization = $accountArgumentSanitization;
        $this->apiConfiguration = $apiConfiguration;
        $this->request = $request;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getAccountDataById(int $id): ?array
    {
        $this->accountId = $id;

        return $this->getAccount($id);
    }

    /**
     * @param array $arguments
     * @return array|null
     */
    public function getAccountDataByArguments(array $arguments): ?array
    {
        $id = (int)$this->accountArgumentSanitization->sanitizeAccountArguments($arguments)['user'];
        $this->accountId = $id;

        return $this->getAccount($id);
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @param int $id
     * @return array|null
     */
    protected function getAccount(int $id): ?array
    {
        $uri = $this->apiConfiguration->getUserUri();
        $uri = ApiUtility::replaceUriPlaceholder([$id], $uri);

        return $this->request->process($uri);
    }
}
