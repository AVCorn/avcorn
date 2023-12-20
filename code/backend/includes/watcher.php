<?php

declare(strict_types=1);

use DI\Container;
use App\Application\Watcher\Watcher;

/**
 * @param Container $container
 * @return void
 */
return function (Container $container) {
    $container->set('watcher', function () {
        return new Watcher();
    });
};
