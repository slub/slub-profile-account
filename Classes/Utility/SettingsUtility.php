<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-account
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileAccount\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class SettingsUtility
{
    /**
     * @return array
     */
    public static function getPluginSettings(): array
    {
        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);

        return $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            ConstantsUtility::EXTENSION_NAME
        );
    }
}
