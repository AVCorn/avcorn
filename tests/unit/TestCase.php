<?php

/**
 * Test Case
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Tests
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace Tests;

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
 * Test Case Class
 *
 * @category TestUnit
 */
class TestCase extends PHPUnit_TestCase
{
    use ProphecyTrait;

    /**
     * Get App Instance
     *
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(): App
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

        // Set up watcher
        $watcher = include __DIR__
            . '/../../code/backend/includes/watcher.php';
        $watcher($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = include __DIR__
            . '/../../code/backend/includes/middleware.php';
        $middleware($app);

        // Register forms
        $forms = include __DIR__
            . '/../../code/backend/includes/forms.php';
        $forms($app);

        // Register routes
        $routes = include __DIR__
            . '/../../code/backend/includes/routes.php';
        $routes($app);

        return $app;
    }

    /**
     * Create Request
     *
     * @param string $method       HTTP Method
     * @param string $path         The Path
     * @param array  $headers      Headers Array
     * @param array  $cookies      Cookies Array
     * @param array  $serverParams Server Paremeters
     *
     * @return Request
     */
    protected function createRequest(
        string $method,
        string $path,
        array  $headers = ['HTTP_ACCEPT' => 'application/json'],
        array  $cookies = [],
        array  $serverParams = []
    ): Request {
        $uri    = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $heads = new Headers();
        foreach ($headers as $name => $value) {
            $heads->addHeader($name, $value);
        }

        return new SlimRequest(
            $method,
            $uri,
            $heads,
            $cookies,
            $serverParams,
            $stream
        );
    }
}
