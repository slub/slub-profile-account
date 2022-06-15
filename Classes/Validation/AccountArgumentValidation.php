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
    /**
     * @param array $arguments
     * @return array
     */
    public function validateUpdateArguments(array $arguments): array
    {
        $error = [];

        if (empty($arguments['GivenNames'])) {
            $error['GivenNames'] = ApiUtility::VALIDATION['isEmpty'];
        }

        if (empty($arguments['Surname'])) {
            $error['Surname'] = ApiUtility::VALIDATION['isEmpty'];
        }

        if (empty($arguments['EmailAddress'])) {
            $error['EmailAddress'] = ApiUtility::VALIDATION['isEmpty'];
        }

        if (!filter_var($arguments['EmailAddress'], FILTER_VALIDATE_EMAIL)) {
            $error['EmailAddress'] = ApiUtility::VALIDATION['isInvalid'];
        }

        if (count($error) > 0) {
            $status = ApiUtility::STATUS[400];
            $status['error'] = $error;

            return $status;
        }

        return [];
    }
}
