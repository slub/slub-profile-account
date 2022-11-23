<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Controller;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserReserveService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class UserReserveController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
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
     * @throws JsonException
     */
    public function currentAction(): ResponseInterface
    {
        $reserveCurrent = $this->userService->getCurrent(
            $this->request->getArguments()
        );

        $this->view->setVariablesToRender(['userReserveCurrent']);
        $this->view->assign('userReserveCurrent', $reserveCurrent);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws JsonException
     */
    public function historyAction(): ResponseInterface
    {
        $reserveHistory = $this->userService->getHistory(
            $this->request->getArguments()
        );

        $this->view->setVariablesToRender(['userReserveHistory']);
        $this->view->assign('userReserveHistory', $reserveHistory);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws JsonException
     */
    public function deleteAction(): ResponseInterface
    {
        $status = $this->userService->getDelete(
            $this->request->getArguments()
        );

        $this->view->setVariablesToRender(['status']);
        $this->view->assign('status', $status);

        return $this->jsonResponse();
    }
}
