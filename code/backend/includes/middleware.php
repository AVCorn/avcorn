<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;

/**
 * @param App $app
 * @return void
 */
return function (App $app) {
    $app->add(SessionMiddleware::class);
};
