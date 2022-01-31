<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model\Dto;

use Slub\SlubProfileAccount\Utility\ConstantsUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class ApiConfiguration
{
    /**
     * @var string
     */
    protected string $userUri = '';

    public function __construct()
    {
        $settings = $this->getPluginSettings();

        $this->setUserUri($settings['api']['path']['user']);
    }

    /**
     * @return string
     */
    public function getUserUri(): string
    {
        return $this->userUri;
    }

    /**
     * @param string $userUri
     */
    public function setUserUri($userUri = ''): void
    {
        $this->userUri = $userUri;
    }

    /**
     * @return array
     */
    protected function getPluginSettings(): array
    {
        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);

        return $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            ConstantsUtility::EXTENSION_NAME
        );
    }
}
