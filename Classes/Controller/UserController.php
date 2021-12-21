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
use Slub\SlubProfileAccount\Domain\Model\User;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserService;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class UserController extends ActionController
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
        $this->view->setVariablesToRender(['userDetail']);
        $this->view->assign('userDetail', $this->user);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function updateAction(): ResponseInterface
    {
        $content = $this->getContent();
        $user = $this->userService->updateUser($this->user, $content);
        $status = $user instanceof User ? 200 : 500;

        $this->view->setVariablesToRender(['status']);
        $this->view->assign('status', ApiUtility::STATUS[$status]);

        return $this->jsonResponse();
    }

    /**
     * @return array
     * @throws \JsonException
     */
    protected function getContent(): array
    {
        return json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        ) ?? [];
    }

    protected function initializeAction(): void
    {
        $this->user = $this->userService->getUser($this->request->getArguments());
    }
}
