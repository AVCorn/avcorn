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
 * @phpversion >= 8.1
 * @category   CMS
 * @package    AVCorn
 * @subpackage Includes
 * @author     Benjamin J. Young <ben@blaher.me>
 * @copyright  2023 Web Elements
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
