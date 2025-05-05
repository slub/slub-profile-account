<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Slub\SlubProfileAccount\Domain\Repository\CategoryRepository;

class UserService
{
    protected CategoryRepository $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $account
     * @return array
     */
    public function getUserByAccount(array $account): array
    {
        $category = $this->categoryRepository->findOneByCode($account['X_category']);

        return [
            'X_category_desc' => $category === null ? '' : $category->getTitle()
        ];
    }
}
