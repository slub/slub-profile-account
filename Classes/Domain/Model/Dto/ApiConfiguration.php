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
    protected string $loginUri = '';
    protected string $userUri = '';
    protected string $passwordUpdateUri = '';
    protected string $pinUpdateUri = '';
    protected string $loanCurrentUri = '';
    protected string $loanHistoryUri = '';
    protected string $loanRenewalUri = '';
    protected string $reserveCurrentUri = '';
    protected string $reserveDeleteUri = '';
    protected string $reserveHistoryUri = '';
    protected string $dataDownloadUri = '';

    public function __construct()
    {
        $settings = SettingsUtility::getPluginSettings();

        $this->setLoginUri($settings['api']['path']['login']);
        $this->setUserUri($settings['api']['path']['user']);
        $this->setPasswordUpdateUri($settings['api']['path']['passwordUpdate']);
        $this->setPinUpdateUri($settings['api']['path']['pinUpdate']);
        $this->setLoanCurrentUri($settings['api']['path']['loanCurrent']);
        $this->setLoanHistoryUri($settings['api']['path']['loanHistory']);
        $this->setLoanRenewalUri($settings['api']['path']['loanRenewal']);
        $this->setReserveCurrentUri($settings['api']['path']['reserveCurrent']);
        $this->setReserveDeleteUri($settings['api']['path']['reserveDelete']);
        $this->setReserveHistoryUri($settings['api']['path']['reserveHistory']);
        $this->setDataDownloadUri($settings['api']['path']['dataDownload']);
    }

    /**
     * @return string
     */
    public function getLoginUri(): string
    {
        return $this->loginUri;
    }

    /**
     * @param string $loginUri
     */
    public function setLoginUri(string $loginUri = ''): void
    {
        $this->loginUri = $loginUri;
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

    /**
     * @return string
     */
    public function getPasswordUpdateUri(): string
    {
        return $this->passwordUpdateUri;
    }

    /**
     * @param string $passwordUpdateUri
     */
    public function setPasswordUpdateUri(string $passwordUpdateUri = ''): void
    {
        $this->passwordUpdateUri = $passwordUpdateUri;
    }

    /**
     * @return string
     */
    public function getPinUpdateUri(): string
    {
        return $this->pinUpdateUri;
    }

    /**
     * @param string $pinUpdateUri
     */
    public function setPinUpdateUri(string $pinUpdateUri = ''): void
    {
        $this->pinUpdateUri = $pinUpdateUri;
    }

    /**
     * @return string
     */
    public function getLoanCurrentUri(): string
    {
        return $this->loanCurrentUri;
    }

    /**
     * @param string $loanCurrentUri
     */
    public function setLoanCurrentUri(string $loanCurrentUri = ''): void
    {
        $this->loanCurrentUri = $loanCurrentUri;
    }

    /**
     * @return string
     */
    public function getLoanHistoryUri(): string
    {
        return $this->loanHistoryUri;
    }

    /**
     * @param string $loanHistoryUri
     */
    public function setLoanHistoryUri(string $loanHistoryUri = ''): void
    {
        $this->loanHistoryUri = $loanHistoryUri;
    }

    /**
     * @return string
     */
    public function getLoanRenewalUri(): string
    {
        return $this->loanRenewalUri;
    }

    /**
     * @param string $loanRenewalUri
     */
    public function setLoanRenewalUri(string $loanRenewalUri = ''): void
    {
        $this->loanRenewalUri = $loanRenewalUri;
    }

    /**
     * @return string
     */
    public function getReserveCurrentUri(): string
    {
        return $this->reserveCurrentUri;
    }

    /**
     * @param string $reserveCurrentUri
     */
    public function setReserveCurrentUri(string $reserveCurrentUri = ''): void
    {
        $this->reserveCurrentUri = $reserveCurrentUri;
    }

    /**
     * @return string
     */
    public function getReserveDeleteUri(): string
    {
        return $this->reserveDeleteUri;
    }

    /**
     * @param string $reserveDeleteUri
     */
    public function setReserveDeleteUri(string $reserveDeleteUri = ''): void
    {
        $this->reserveDeleteUri = $reserveDeleteUri;
    }

    /**
     * @return string
     */
    public function getReserveHistoryUri(): string
    {
        return $this->reserveHistoryUri;
    }

    /**
     * @param string $reserveHistoryUri
     */
    public function setReserveHistoryUri(string $reserveHistoryUri = ''): void
    {
        $this->reserveHistoryUri = $reserveHistoryUri;
    }

    /**
     * @return string
     */
    public function getDataDownloadUri(): string
    {
        return $this->dataDownloadUri;
    }

    /**
     * @param string $dataDownloadUri
     */
    public function setDataDownloadUri(string $dataDownloadUri = ''): void
    {
        $this->dataDownloadUri = $dataDownloadUri;
    }
}
