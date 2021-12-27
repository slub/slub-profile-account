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
use Slub\SlubProfileAccount\Domain\Model\User\Dashboard as UserDashboard;
use Slub\SlubProfileAccount\Mvc\View\JsonView;
use Slub\SlubProfileAccount\Service\UserDashboardService;
use Slub\SlubProfileAccount\Utility\ApiUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;

class UserDashboardController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
    protected ?UserDashboard $userDashboard;
    protected UserDashboardService $userDashboardService;

    /**
     * @param UserDashboardService $userDashboardService
     */
    public function __construct(UserDashboardService $userDashboardService)
    {
        $this->userDashboardService = $userDashboardService;
    }

    /**
     * @return ResponseInterface
     * @throws UnknownObjectException|\JsonException
     * @throws IllegalObjectTypeException
     */
    public function updateAction(): ResponseInterface
    {
        $userDashboard = $this->userDashboardService->updateUser($this->userDashboard);
        $status = $userDashboard instanceof UserDashboard ? 200 : 500;

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
            $this->userDashboard = $this->userDashboardService->getUser(
                $this->request->getArguments()
            );
        } catch (IllegalObjectTypeException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
