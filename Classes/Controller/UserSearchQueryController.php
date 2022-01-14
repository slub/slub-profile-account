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
use Slub\SlubProfileAccount\Domain\Model\User\SearchQuery as User;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserSearchQueryService as UserService;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;

class UserSearchQueryController extends ActionController
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
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws \JsonException
     */
    public function addAction(): ResponseInterface
    {
        $user = $this->userService->addUser($this->user);
        $status = $user instanceof User ? 200 : 500;

        $this->view->setVariablesToRender(['status']);
        $this->view->assign('status', ApiUtility::STATUS[$status]);

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
