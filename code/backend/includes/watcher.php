<?php

/**
 * Watcher configuration
 *
 * PHP version 8.1
 *
 * @param Container $container
 *
 * @return void
 *
 * @category   AVCorn
 * @phpversion >= 8.1
 */

declare(strict_types=1);

use DI\ContainerBuilder;
use App\Application\Watcher\Watcher;
use App\Application\Watcher\WatcherInterface;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            WatcherInterface::class => function () {
                return new Watcher();
            }
        ]
    );
};
