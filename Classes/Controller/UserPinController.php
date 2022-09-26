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
use Slub\SlubProfileAccount\Service\UserPinService;
use Slub\SlubProfileAccount\Service\UserAccountService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

class UserPinController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
    protected ?User $user;
    protected UserPinService $userPinService;
    protected UserService $userService;

    /**
     * @param UserPinService $userPinService
     * @param UserService $userService
     */
    public function __construct(
        UserPinService $userPinService,
        UserService $userService
    ) {
        $this->userPinService = $userPinService;
        $this->userService = $userService;
    }

    /**
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function updateAction(): ResponseInterface
    {
        $status = $this->userPinService->update($this->user);

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
