<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

class WidgetValidator
{
    protected array $pattern = [
        '/[^_a-zA-Z\s]/',
        '/ /'
    ];

    /**
     * @param array $widgets
     * @return array
     */
    public function validate(array $widgets): array
    {
        $validWidgets = [];

        foreach ($widgets as $widget) {
            $validWidgets[] = $this->validateString($widget);
        }

        return $validWidgets;
    }

    /**
     * @param string $string
     * @return string
     */
    protected function validateString($string = ''): string
    {
        return preg_replace($this->pattern, '', $string);
    }
}
