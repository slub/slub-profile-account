<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Sanitization;

class WidgetSanitization
{
    protected array $stringPattern = [
        '/[^_a-zA-Z\s]/',
        '/ /'
    ];

    /**
     * @param array $widgets
     * @return array
     */
    public function sanitize(array $widgets): array
    {
        $sanitizedWidgets = [];

        foreach ($widgets as $widget) {
            $sanitizedWidgets[] = $this->sanitizeString($widget);
        }

        return $sanitizedWidgets;
    }

    /**
     * @param string $string
     * @return string
     */
    protected function sanitizeString(string $string = ''): string
    {
        return preg_replace($this->stringPattern, '', $string);
    }
}
