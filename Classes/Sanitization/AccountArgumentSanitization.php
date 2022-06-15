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
    protected array $disallowedCharacters = [
        '*', '+', '<', '>', '[', ']', '(', ')', '%', '/', '$', '.', ',', ';', '!', '?', '#', '='
    ];

    /**
     * @param array $arguments
     * @return array
     */
    public function sanitizeAccountArguments(array $arguments): array
    {
        if (count($arguments) === 0) {
            return ['user' => 0];
        }

        $this->sanitizedArguments = [];
        $this->sanitizeInteger('user', $arguments['user']);

        return $this->sanitizedArguments;
    }

    /**
     * The argument "email" is not written here because in validation this field will be checked.
     *
     * @param array $arguments
     * @return array
     */
    public function sanitizeUpdateArguments(array $arguments): array
    {
        $this->sanitizedArguments = $arguments;

        $this->sanitizeString('GivenNames', $arguments['GivenNames'] ?? '');
        $this->sanitizeString('Surname', $arguments['Surname'] ?? '');

        $this->sanitizeString('PostalAddress1', $arguments['PostalAddress1'] ?? '');
        $this->sanitizeString('PostalAddress2', $arguments['PostalAddress2'] ?? '');
        $this->sanitizeString('PostalCity', $arguments['PostalCity'] ?? '');
        $this->sanitizeString('PostalPostCode', $arguments['PostalPostCode'] ?? '');
        $this->sanitizeString('PostalCountry', $arguments['PostalCountry'] ?? '');

        $this->sanitizeString('ResAddress1', $arguments['ResAddress1'] ?? '');
        $this->sanitizeString('ResAddress2', $arguments['ResAddress2'] ?? '');
        $this->sanitizeString('ResAddressCity', $arguments['ResAddressCity'] ?? '');
        $this->sanitizeString('ResAddressPostCode', $arguments['ResAddressPostCode'] ?? '');
        $this->sanitizeString('ResAddressCountry', $arguments['ResAddressCountry'] ?? '');

        return $this->sanitizedArguments;
    }

    /**
     * @param string $key
     * @param string $string
     */
    protected function sanitizeString(string $key = '', string $string = ''): void
    {
        $this->sanitizedArguments[$key] = trim(str_replace($this->disallowedCharacters, '', $string));
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function sanitizeInteger(string $key = '', string $value = ''): void
    {
        if (!empty($value)) {
            $this->sanitizedArguments[$key] = (int)$value;
        }
    }
}
