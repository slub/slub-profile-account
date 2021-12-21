<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Utility;

class ApiUtility
{
    public const STATUS = [
        200 => [
            'code' => 200,
            'message' => 'OK'
        ],
        500 => [
            'code' => 500,
            'message' => 'Internal Server Error'
        ]
    ];

    public const URI_PLACEHOLDER = [
        '###USER_ID###'
    ];

    /**
     * @param array $replace
     * @param string $uri
     * @return string
     */
    public static function replaceUriPlaceholder(array $replace, string $uri): string
    {
        return str_replace(self::URI_PLACEHOLDER, $replace, $uri);
    }
}
