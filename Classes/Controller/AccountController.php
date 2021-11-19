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
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class AccountController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;

    /**
     * @return ResponseInterface
     */
    public function detailAction(): ResponseInterface
    {
        $account = [
            'firstname' => 'test',
            'lastname' => 'daten'
        ];

        $this->view->setVariablesToRender(['account']);
        $this->view->assign('account', $account);

        return $this->jsonResponse();
    }
}
