<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

use Slub\SlubProfileAccount\Domain\Model\Dto\ApiConfiguration;
use Slub\SlubProfileAccount\Http\Request;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PinArgumentValidation
{
    protected const REQUIRED_ARGUMENTS = [
        'password',
        'pin',
        'pinRepeat'
    ];

    /**
     * @param array $arguments
     * @param int $accountId
     * @return array
     * @throws \JsonException
     */
    public function validateUpdateArguments(array $arguments, int $accountId): array
    {
        if (count($arguments) === 0) {
            return [];
        }

        $error = $this->isEmpty($arguments) ?? [];

        if (isset($arguments['password'])) {
            $error = array_merge($error, $this->validatePassword((string)$accountId, $arguments['password']));
        }

        if (isset($arguments['pin'])) {
            $error = array_merge($error, $this->validatePin('pin', $arguments['pin']));
        }

        if (isset($arguments['pinRepeat'])) {
            $error = array_merge($error, $this->validatePin('pinRepeat', $arguments['pinRepeat']));
        }

        if (isset($arguments['pin']) && isset($arguments['pinRepeat']) && !isset($error['pinRepeat'])) {
            $error = array_merge($error, $this->comparePins([$arguments['pin'], $arguments['pinRepeat']]));
        }

        if (count($error) > 0) {
            $status = ApiUtility::STATUS[400];
            $status['error'] = $error;

            return $status;
        }

        return [];
    }

    /**
     * @param array $pins
     * @return array
     */
    private function comparePins(array $pins): array
    {
        if ($pins[0] !== $pins[1]) {
            return [
                'pinRepeat' => ApiUtility::VALIDATION['isInvalidPinRepeat']
            ];
        }

        return [];
    }

    /**
     * @param string $username
     * @param string $password
     * @return array
     * @throws \JsonException
     */
    private function validatePassword(string $username, string $password): array
    {
        $uri = GeneralUtility::makeInstance(ApiConfiguration::class)
            ->getLoginUri();

        $processed = GeneralUtility::makeInstance(Request::class)
            ->process($uri, 'POST', [
                'body' => json_encode([
                    'username' => $username,
                    'password' => $password
                ])
        ]);

        if ($processed['status'] === 1) {
            return [];
        }

        return [
            'password' => ApiUtility::VALIDATION['isInvalidLogin']
        ];
    }

    /**
     * @param string $field
     * @param string $pin
     * @return array
     */
    private function validatePin(string $field, string $pin = ''): array
    {
        if (strlen($pin) !== 4) {
            return [
                $field => ApiUtility::VALIDATION['isInvalidPin']
            ];
        }

        return [];
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function isEmpty(array $arguments): array
    {
        if (count($arguments) === 0) {
            return [];
        }

        $error = [];

        foreach ($arguments as $key => $value) {
            if (in_array($key, self::REQUIRED_ARGUMENTS) && empty($value)) {
                $error[$key] = ApiUtility::VALIDATION['isEmpty'];
            }
        }

        return $error;
    }
}
