<?php

/**
 * Form configuration
 *
 * PHP version 8.1
 *
 * @param  App $app
 *
 * @return void
 *
 * @category   AVCorn
 * @phpversion >= 8.1
 */

declare(strict_types=1);

use App\Application\Middleware\FormMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(FormMiddleware::class);
};
