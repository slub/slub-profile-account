<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Utility;

class FileUtility
{
    /**
     * @return array
     * @throws \JsonException
     */
    public static function getContent(): array
    {
        return json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        ) ?? [];
    }
}
