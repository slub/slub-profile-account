<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\ViewHelpers\Php;

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Check if data is an array
 *
 * Examples
 * ========
 *
 * Regular syntax
 * --------------
 *
 * <slub:php.isArray data="{data}" />
 *
 * Inline syntax
 * -------------
 *
 * {data -> slub:php.isArray()}
 */
class IsArrayViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('data', 'mixed', 'Data to check if it is an array.', true);
    }

    /**
     * @param array $arguments
     * @param Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): bool {
        $data = $renderChildrenClosure();

        if ($data === null) {
            $data = $arguments['data'];
        }

        return is_array($data);
    }
}
