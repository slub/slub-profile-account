<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Slub\SlubProfileAccount\Domain\Model\User\Account as User;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserAccountService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

class UserAccountController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
    protected ?User $user;
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return ResponseInterface
     */
    public function detailAction(): ResponseInterface
    {
        $this->view->setVariablesToRender(['userAccountDetail']);
        $this->view->assign('userAccountDetail', $this->user);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function updateAction(): ResponseInterface
    {
        $status = $this->userService->updateUser($this->user);

        $this->view->setVariablesToRender(['status']);
        $this->view->assign('status', $status);

        return $this->jsonResponse();
    }

    /**
     * @throws Exception
     */
    protected function initializeAction(): void
    {
        try {
            $this->user = $this->userService->getUser(
                $this->request->getArguments()
            );
        } catch (IllegalObjectTypeException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
