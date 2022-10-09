<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Utility;

class CacheUtility
{
    /**
     * @param string $string
     * @return string
     */
    public static function getIdentifier(string $string): string
    {
        return md5($string);
    }

    /**
     * @return int
     */
    public static function getAccountLifeTime(): int
    {
        return (int)SettingsUtility::getPluginSettings()['cache']['account']['lifeTime']
            ?? ConstantsUtility::CACHE_ACCOUNT_LIFETIME;
    }
}
