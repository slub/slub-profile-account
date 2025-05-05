<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

use Slub\SlubProfileAccount\Utility\ApiUtility;

class AccountArgumentValidation
{
    protected const REQUIRED_ARGUMENTS = [
        'PostalAddress1',
        'PostalCity',
        'PostalPostCode',
        'PostalCountry'
    ];

    /**
     * @param array $arguments
     * @return array
     */
    public function validateUpdateArguments(array $arguments): array
    {
        if (count($arguments) === 0) {
            return [];
        }

        $error = $this->isEmpty($arguments) ?? [];

        if (isset($arguments['EmailAddress'])) {
            $error = array_merge($error, $this->validateEMail($arguments['EmailAddress']));
        }

        if (count($error) > 0) {
            $status = ApiUtility::STATUS[400];
            $status['error'] = $error;

            return $status;
        }

        return [];
    }

    /**
     * @param string $email
     * @return array
     */
    private function validateEMail(string $email = ''): array
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'EmailAddress' => ApiUtility::VALIDATION['isInvalid']
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
