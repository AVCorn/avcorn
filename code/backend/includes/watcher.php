<?php

/**
 * Watcher configuration
 *
 * PHP version 8.2
 *
 * @param Container $container
 *
 * @return void
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Includes
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
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
