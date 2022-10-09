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
use Slub\SlubProfileAccount\Service\UserLoanHistoryService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class UserLoanHistoryController extends ActionController
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
    public function detailAction(): ResponseInterface
    {
        $loanHistory = $this->userService->getData(
            $this->request->getArguments()
        );

        $this->view->setVariablesToRender(['userLoanHistoryDetail']);
        $this->view->assign('userLoanHistoryDetail', $loanHistory);

        return $this->jsonResponse();
    }
}
