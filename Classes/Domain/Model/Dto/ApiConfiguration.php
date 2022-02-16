<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Domain\Model\Dto;

use Slub\SlubProfileAccount\Utility\SettingsUtility;

class ApiConfiguration
{
    /**
     * @var string
     */
    protected string $userUri = '';

    public function __construct()
    {
        $settings = SettingsUtility::getPluginSettings();

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
    public function setUserUri(string $userUri = ''): void
    {
        $this->userUri = $userUri;
    }
}
