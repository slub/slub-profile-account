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
use Slub\SlubProfileAccount\Utility\ApiUtility;
use Slub\SlubProfileAccount\Validation\AccountArgumentValidator;
use Slub\SlubProfileEvents\Http\Request;

class AccountService
{
    protected AccountArgumentValidator $accountArgumentValidator;
    protected ApiConfiguration $apiConfiguration;
    protected Request $request;
    protected int $accountId;

    /**
     * @param AccountArgumentValidator $accountArgumentValidator
     * @param ApiConfiguration $apiConfiguration
     * @param Request $request
     */
    public function __construct(
        AccountArgumentValidator $accountArgumentValidator,
        ApiConfiguration $apiConfiguration,
        Request $request
    ) {
        $this->accountArgumentValidator = $accountArgumentValidator;
        $this->apiConfiguration = $apiConfiguration;
        $this->request = $request;
    }

    /**
     * @param array $arguments
     * @return array|null
     */
    public function getAccountData(array $arguments): ?array
    {
        $this->accountId = (int)$this->accountArgumentValidator->validateAccountArguments($arguments)['user'];

        $uri = $this->apiConfiguration->getUserUri();
        $uri = ApiUtility::replaceUriPlaceholder([$this->accountId], $uri);

        return $this->request->process($uri);
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }
}
