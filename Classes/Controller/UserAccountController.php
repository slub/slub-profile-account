<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Controller;

use Psr\Http\Message\ResponseInterface;
use Slub\SlubProfileAccount\Domain\Model\User\Account as UserAccount;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserAccountService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

class UserAccountController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
    protected ?UserAccount $userAccount;
    protected UserAccountService $userAccountService;

    /**
     * @param UserAccountService $userAccountService
     */
    public function __construct(UserAccountService $userAccountService)
    {
        $this->userAccountService = $userAccountService;
    }

    /**
     * @return ResponseInterface
     */
    public function detailAction(): ResponseInterface
    {
        $this->view->setVariablesToRender(['userAccountDetail']);
        $this->view->assign('userAccountDetail', $this->userAccount);

        return $this->jsonResponse();
    }

    protected function initializeAction(): void
    {
        try {
            $this->userAccount = $this->userAccountService->getUser(
                $this->request->getArguments()
            );
        } catch (IllegalObjectTypeException $e) {
        }
    }
}
