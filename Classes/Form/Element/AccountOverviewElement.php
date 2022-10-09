<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Form\Element;

use Slub\SlubProfileAccount\Service\AccountService;
use Slub\SlubProfileAccount\Utility\ConstantsUtility;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class AccountOverviewElement extends AbstractFormElement
{
    protected string $template = 'AccountOverview';
    protected string $templateRootPath = 'Templates/Backend/Form/Element';
    protected string $partialRootPath = 'Partials/Backend/Form/Element';
    protected string $layoutRootPath = 'Layouts/Backend';

    /**
     * @return array
     */
    public function render(): array
    {
        $account = $this->getAccount((int)$this->data['databaseRow']['account_id']);
        $result['html'] = $this->getHtml($account);

        return $result;
    }

    /**
     * @param array $account
     * @return string
     */
    protected function getHtml(array $account): string
    {
        $root = 'EXT:' . ConstantsUtility::EXTENSION_KEY . '/Resources/Private/';

        /** @var StandaloneView $standaloneView */
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setPartialRootPaths([$root . $this->partialRootPath]);
        $standaloneView->setTemplateRootPaths([$root . $this->templateRootPath]);
        $standaloneView->setLayoutRootPaths([$root . $this->layoutRootPath]);
        $standaloneView->setTemplate($this->template);
        $standaloneView->assign('account', $account);

        return $standaloneView->render();
    }

    /**
     * @param int $accountId
     * @return array
     */
    protected function getAccount(int $accountId): array
    {
        /** @var AccountService $accountService */
        $accountService = GeneralUtility::makeInstance(AccountService::class);

        return $accountService->getAccountById($accountId) ?? [];
    }
}
