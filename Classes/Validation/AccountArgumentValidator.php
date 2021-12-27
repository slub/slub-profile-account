<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

class AccountArgumentValidator
{
    protected array $validArguments = [];

    /**
     * @param array $arguments
     * @return array
     */
    public function validateAccountArguments(array $arguments): array
    {
        if (count($arguments) === 0) {
            return ['user' => 0];
        }

        $this->validateInteger('user', $arguments['user']);

        return $this->validArguments;
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function validateInteger($key = '', $value = ''): void
    {
        if (!empty($value)) {
            $this->validArguments[$key] = (int)$value;
        }
    }
}
