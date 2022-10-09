<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Utility;

class ConstantsUtility
{
    public const EXTENSION_NAME = 'slubprofileaccount';
    public const EXTENSION_KEY = 'slub_profile_account';
    public const LANGUAGE_PATH_BACKEND = 'LLL:EXT:' . self::EXTENSION_KEY . '/Resources/Private/Language/locallang_backend.xlf';
    public const CACHE_ACCOUNT_LIFETIME = 3600;
}
