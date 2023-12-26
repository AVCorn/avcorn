<?php

declare(strict_types=1);

namespace Benchmark;

require __DIR__ . '/../../code/vendor/autoload.php';

use DI\ContainerBuilder;
use Exception;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

/**
 * AppBench
 *
 * PHP version 8.1
 *
 * @category   CMS
 * @package    AVCorn
 * @subpackage Benchmark
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */
class AppBench
{
    /**
     * Benchmark App Creation
     *
     * PHP version 8.1
     *
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchCreate()
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Container intentionally not compiled for tests.

        // Set up settings
        $settings = include __DIR__
            . '/../../code/backend/includes/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = include __DIR__
            . '/../../code/backend/includes/dependencies.php';
        $dependencies($containerBuilder);

        // Set up repositories
        $repositories = include __DIR__
            . '/../../code/backend/includes/repositories.php';
        $repositories($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = include __DIR__
            . '/../../code/backend/includes/middleware.php';
        $middleware($app);

        // Register routes
        $routes = include __DIR__
            . '/../../code/backend/includes/routes.php';
        $routes($app);
    }

    /**
     * Benchmark App Request
     *
     * PHP version 8.1
     *
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchRequest()
    {
        $uri = new Uri('', '', 80, '/');
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);
        $heads = new Headers();

        $request = new SlimRequest(
            'GET',
            $uri,
            $heads,
            [],
            [],
            $stream
        );
    }
}
