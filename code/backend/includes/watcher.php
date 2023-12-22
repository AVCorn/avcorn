<?php

/**
 * Watcher configuration
 *
 * PHP version 8.1
 * @phpversion >= 8.1
 *
 * @param  Container $container
 *
 * @return void
 */

declare(strict_types=1);

use DI\Container;
use App\Application\Watcher\Watcher;

return function (Container $container) {
    $container->set('watcher', function () {
        return new Watcher();
    });
};
