<?php

/**
 * Dependencies configuation
 *
 * PHP version 8.1
 *
 * @param ContainerBuilder $containerBuilder
 *
 * @return void
 *
 * @phpversion >= 8.1
 * @category   CMS
 * @package    AVCorn
 * @subpackage Includes
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            LoggerInterface::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);

                $loggerSettings = $settings->get('logger');
                $logger = new Logger($loggerSettings['name']);

                $processor = new UidProcessor();
                $logger->pushProcessor($processor);

                $handler = new StreamHandler(
                    $loggerSettings['path'],
                    $loggerSettings['level']
                );
                $logger->pushHandler($handler);

                return $logger;
            },
        ]
    );
};
