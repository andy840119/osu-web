<?php

/**
 *    Copyright (c) ppy Pty Ltd <contact@ppy.sh>.
 *
 *    This file is part of osu!web. osu!web is distributed with the hope of
 *    attracting more community contributions to the core ecosystem of osu!.
 *
 *    osu!web is free software: you can redistribute it and/or modify
 *    it under the terms of the Affero GNU General Public License version 3
 *    as published by the Free Software Foundation.
 *
 *    osu!web is distributed WITHOUT ANY WARRANTY; without even the implied
 *    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *    See the GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with osu!web.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Http\Middleware;

use ChaseConey\LaravelDatadogHelper\Middleware\LaravelDatadogMiddleware;
use Datadog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DatadogMetrics extends LaravelDatadogMiddleware
{
    /**
     * Logs the duration of a specific request through the application
     *
     * @param Request $request
     * @param Response $response
     * @param float $startTime
     */
    protected static function logDuration(Request $request, Response $response, $startTime)
    {
        $duration = microtime(true) - $startTime;
        $action = 'ErrorPage';
        $section = 'error';

        $route = $request->route();
        if ($route !== null) {
            $controller = $route->getController();
            if ($controller !== null) {
                $section = method_exists($controller, 'getSection') ? $controller->getSection() : 'unknown';

                $actionPrefix = str_replace('App\\Http\\Controllers\\', '', get_class($controller));
                $actionPrefix = str_replace('\\', '', $actionPrefix);
                $action = snake_case("{$actionPrefix}:{$route->getActionMethod()}");
            }
        }

        $tags = [
            'action' => $action,
            'section' => $section,
            'status_code' => $response->getStatusCode(),
        ];

        Datadog::timing(config('datadog-helper.prefix_web').'.request_time', $duration, 1, $tags);
    }
}
