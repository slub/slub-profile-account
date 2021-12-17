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
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class UserController extends ActionController
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
     */
    public function detailAction(): ResponseInterface
    {
        $user = $this->userService->getUser($this->request->getArguments());

        $this->view->setVariablesToRender(['userDetail']);
        $this->view->assign('userDetail', $user);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function updateAction(): ResponseInterface
    {
        $user = $this->userService->getUser($this->request->getArguments());
        $receivedData = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR) ?? [];

        $data = [
            'user' => $user,
            'receivedData' => $receivedData
        ];

        // @todo just send the received data back to check if the circle works. Next step: save the data here
        // create domain model, dashboard_widgets colon separated string, external user data as array to separate data?
        // the update needs to accept the "widgets" array

        $this->view->setVariablesToRender(['userUpdate']);
        $this->view->assign('userUpdate', $data);

        return $this->jsonResponse();
    }
}
