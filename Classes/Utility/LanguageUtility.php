<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Utility;

use TYPO3\CMS\Core\Localization\LanguageService;

class LanguageUtility
{
    /**
     * @return LanguageService
     */
    public static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Sets the sys_language_uid to All languages
     */
    public static function setLanguageProperty($object)
    {
        $object->_setProperty('_localizedUid', null);
        $object->_setProperty('_languageUid', '-1');

        return $object;
    }
}
