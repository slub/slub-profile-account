<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Service;

use Slub\SlubProfileAccount\Sanitization\WidgetSanitization;

class DashboardService
{
    protected WidgetSanitization $widgetSanitization;

    /**
     * @param WidgetSanitization $widgetSanitization
     */
    public function __construct(WidgetSanitization $widgetSanitization)
    {
        $this->widgetSanitization = $widgetSanitization;
    }

    /**
     * @param array $widgets
     * @return string
     * @throws \JsonException
     */
    public function setDashboardWidgets(array $widgets): string
    {
        $dashboardWidgets = $this->widgetSanitization->sanitize($widgets);

        return implode(',', $dashboardWidgets);
    }
}
