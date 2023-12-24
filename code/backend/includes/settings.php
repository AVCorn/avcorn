<?php

/**
 * Settings configuration
 *
 * PHP version 8.1
 *
 * @param ContainerBuilder $containerBuilder
 *
 * @return void
 *
 * @category   AVCorn
 * @phpversion >= 8.1
 */

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            SettingsInterface::class => function () {
                $dev = true;
                if (isset($_ENV['production'])) {
                    $dev = false;
                }

                return new Settings(
                    [
                    'displayErrorDetails' => $dev,
                    'logError'            => false,
                    'logErrorDetails'     => false,
                    'logger' => [
                        'name' => 'slim-app',
                        'path' => isset($_ENV['docker'])
                            ? 'php://stdout'
                            : __DIR__ . '/logs/app.log',
                        'level' => Logger::DEBUG,
                    ],
                    ]
                );
            }
        ]
    );
};
