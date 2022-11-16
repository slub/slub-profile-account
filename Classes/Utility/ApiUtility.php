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
        400 => [
            'code' => 400,
            'message' => 'Bad Request',
        ],
        405 => [
            'code' => 405,
            'message' => 'Bad Request. No renewable data given.',
        ],
        410 => [
            'code' => 410,
            'message' => 'Bad Request. Renewal not possible.',
        ],
        500 => [
            'code' => 500,
            'message' => 'Internal Server Error'
        ]
    ];

    public const VALIDATION = [
        'isEmpty' => [
            'code' => 'is_empty',
            'message' => 'This field is required.'
        ],
        'isInvalid' => [
            'code' => 'is_invalid',
            'message' => 'This field is invalid.'
        ],
        'isInvalidLogin' => [
            'code' => 'is_invalid_login',
            'message' => 'This field is invalid.'
        ],
        'isInvalidPin' => [
            'code' => 'is_invalid_pin',
            'message' => 'This field is invalid',
            'info' => 'Only four numbers exactly.'
        ],
        'isInvalidPinRepeat' => [
            'code' => 'is_invalid_pin_repeat',
            'message' => 'This field is not even with pin.'
        ],
    ];

    public const URI_PLACEHOLDER = [
        '###USER_ID###',
        '###BARCODE###'
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
