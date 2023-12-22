<?php

/**
 * Middleware configuration
 *
 * PHP version 8.1
 * @phpversion >= 8.1
 *
 * @param App $app
 *
 * @return void
 */

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
};
