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
use Slub\SlubProfileAccount\Validation\PasswordArgumentValidation;

class UserPasswordService
{
    protected ApiConfiguration $apiConfiguration;
    protected PasswordArgumentValidation $passwordArgumentValidation;
    protected Request $request;

    /**
     * @param ApiConfiguration $apiConfiguration
     * @param PasswordArgumentValidation $passwordArgumentValidation
     * @param Request $request
     */
    public function __construct(
        ApiConfiguration $apiConfiguration,
        PasswordArgumentValidation $passwordArgumentValidation,
        Request $request
    ) {
        $this->apiConfiguration = $apiConfiguration;
        $this->passwordArgumentValidation = $passwordArgumentValidation;
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
        $data = FileUtility::getContent()['password'];

        if ($data === null) {
            return ApiUtility::STATUS[400];
        }

        $validated = $this->passwordArgumentValidation->validateUpdateArguments($data, $accountId);

        if ($validated['code'] === 400) {
            return $validated;
        }

        $uri = $this->apiConfiguration->getPasswordUpdateUri();
        $uri = ApiUtility::replaceUriPlaceholder([$accountId], $uri);

        $processed = $this->request->process($uri, 'POST', [
            'body' => json_encode([
                'new_password' => $data['newPassword'],
                'patron' => (string)$accountId
            ])
        ]);

        if ($processed['status'] === 1) {
            return ApiUtility::STATUS[200];
        }

        return ApiUtility::STATUS[500];
    }
}
