<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Controller;

use Doctrine\DBAL\DBALException;
use Exception;
use JsonException;
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
     */
    public function detailAction(): ResponseInterface
    {
        $this->view->setVariablesToRender(['userSearchQueryDetail']);
        $this->view->assign('userSearchQueryDetail', $this->user);

        return $this->jsonResponse();
    }

    /**
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws JsonException
     * @throws DBALException
     */
    public function updateAction(): ResponseInterface
    {
        $this->userService->updateUser($this->user);

        $this->view->setVariablesToRender(['status']);
        $this->view->assign('status', ApiUtility::STATUS[200]);

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
