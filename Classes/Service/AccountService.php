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
use Slub\SlubProfileAccount\Utility\CacheUtility;
use Slub\SlubProfileEvents\Http\Request;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class AccountService
{
    protected AccountArgumentSanitization $accountArgumentSanitization;
    protected int $accountId;
    protected ApiConfiguration $apiConfiguration;
    protected FrontendInterface $cache;
    protected Request $request;

    /**
     * @param AccountArgumentSanitization $accountArgumentSanitization
     * @param ApiConfiguration $apiConfiguration
     * @param FrontendInterface $cache
     * @param Request $request
     */
    public function __construct(
        AccountArgumentSanitization $accountArgumentSanitization,
        ApiConfiguration $apiConfiguration,
        FrontendInterface $cache,
        Request $request
    ) {
        $this->accountArgumentSanitization = $accountArgumentSanitization;
        $this->apiConfiguration = $apiConfiguration;
        $this->cache = $cache;
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
        $cacheIdentifier = CacheUtility::getIdentifier((string)$id);

        if (!$this->cache->has($cacheIdentifier)) {
            $data = $this->requestAccount($id);
            $lifeTime = CacheUtility::getAccountLifeTime();

            $this->cache->set($cacheIdentifier, $data, ['accountId_' . $id], $lifeTime);
        }

        return $this->cache->get($cacheIdentifier);
    }

    /**
     * @param int $id
     * @return array|null
     */
    protected function requestAccount(int $id): ?array
    {
        $uri = $this->apiConfiguration->getUserUri();
        $uri = ApiUtility::replaceUriPlaceholder([$id], $uri);

        return $this->request->process($uri, 'GET', [
            'headers' => [
                'X-SLUB-Standard' => 'paia_ext',
                'X-SLUB-pretty' => '1',
                'X-SLUB-sort' => 'ASC'
            ]
        ]);
    }
}
