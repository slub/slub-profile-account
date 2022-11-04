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
use Slub\SlubProfileAccount\Domain\Model\User\Account as User;
use Slub\SlubProfileAccount\Http\Request;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use Slub\SlubProfileAccount\Utility\FileUtility;
use Slub\SlubProfileAccount\Validation\PinArgumentValidation;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class UserPinService
{
    protected ApiConfiguration $apiConfiguration;
    protected PinArgumentValidation $pinArgumentValidation;
    protected Request $request;

    /**
     * @param ApiConfiguration $apiConfiguration
     * @param PinArgumentValidation $pinArgumentValidation
     * @param Request $request
     */
    public function __construct(
        ApiConfiguration $apiConfiguration,
        PinArgumentValidation $pinArgumentValidation,
        Request $request
    ) {
        $this->apiConfiguration = $apiConfiguration;
        $this->pinArgumentValidation = $pinArgumentValidation;
        $this->request = $request;
    }

    /**
     * @param User $user
     * @return array
     * @throws \JsonException
     */
    public function update(User $user): array
    {
        $accountId = $user->getAccountId();
        $data = FileUtility::getContent()['pin'];

        if ($data === null) {
            return ApiUtility::STATUS[400];
        }

        $validated = $this->pinArgumentValidation->validateUpdateArguments($data, $accountId);

        if ($validated['code'] === 400) {
            return $validated;
        }

        $uri = $this->apiConfiguration->getPinUpdateUri();
        $uri = ApiUtility::replaceUriPlaceholder([$accountId], $uri);

        $processed = $this->request->process($uri, 'PATCH', [
            'body' => json_encode([
                'SelfCheckPin' => $data['pin']
            ])
        ]);

        if ($processed['status'] === 1) {
            return ApiUtility::STATUS[200];
        }

        return ApiUtility::STATUS[500];
    }
}
