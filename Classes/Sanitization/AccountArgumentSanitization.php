<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Sanitization;

class AccountArgumentSanitization
{
    protected array $sanitizedArguments = [];

    /**
     * @param array $arguments
     * @return array
     */
    public function sanitizeAccountArguments(array $arguments): array
    {
        if (count($arguments) === 0) {
            return ['user' => 0];
        }

        $this->sanitizeInteger('user', $arguments['user']);

        return $this->sanitizedArguments;
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function sanitizeInteger($key = '', $value = ''): void
    {
        if (!empty($value)) {
            $this->sanitizedArguments[$key] = (int)$value;
        }
    }
}
