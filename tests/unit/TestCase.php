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

namespace Tests\Unit;

use DI\ContainerBuilder;
use Exception;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;
use Slim\Views\Twig as Twig;
use Slim\Views\TwigMiddleware;

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
     * @param bool $production Production Flag (optional)
     *
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(bool $production = false): App
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        $code_dir = '/../../code/';

        // Setup caching
        if ($production) {
            $containerBuilder->enableCompilation(
                __DIR__
                    . $code_dir
                    . '/cache'
            );
        }

        // Container intentionally not compiled for tests.

        // Set up settings
        $settings = include __DIR__
            . $code_dir
            . '/backend/source/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = include __DIR__
            . $code_dir
            . '/backend/source/dependencies.php';
        $dependencies($containerBuilder);

        // Set up repositories
        $repositories = include __DIR__
            . $code_dir
            . '/backend/source/repositories.php';
        $repositories($containerBuilder);

        // Set up watcher
        $watcher = include __DIR__
            . $code_dir
            . '/backend/source/watcher.php';
        $watcher($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Create Twig
        $twig_config = [];
        $twig = Twig::create(
            __DIR__
            . $code_dir
                . '/frontend/',
            $twig_config
        );

        // Add Twig-View Middleware
        $app->add(TwigMiddleware::create($app, $twig));

        // Register middleware
        $middleware = include __DIR__
            . $code_dir
            . '/backend/source/middleware.php';
        $middleware($app);

        // Register forms
        $forms = include __DIR__
            . $code_dir
            . '/backend/source/forms.php';
        $forms($app);

        // Register routes
        $routes = include __DIR__
            . $code_dir
            . '/backend/source/routes.php';
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
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri    = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $heads = new Headers();
        foreach ($headers as $name => $value) {
            $heads->addHeader($name, $value);
        }

        return new Request(
            $method,
            $uri,
            $heads,
            $cookies,
            $serverParams,
            $stream
        );
    }

    /**
     * Create Config
     *
     * @return array
     */
    protected function createConfig(): array
    {
        $config = [];

        // build out config for each route
        $config['uri']    = '/';
        $config['layout'] = 'main';
        $config['page']   = 'home';

        $config['template'] = '/_default/';
        $config['templates_path'] = '/templates/';
        $config['template_path'] = '/templates/_default/';
        $config['layout_path'] = '/templates/_default/layouts/main.html';
        $config['assets_dir'] = '/assets/';

        $config['themes'] = [
            'default' => '/_default/',
            'marketing' => '/examples/categories/marketing/',
            'lawncare' => '/examples/categories/lawncare/',
        ];

        $root = '/../../';
        $config['paths'] = [
            'frontend'     => __DIR__
                . $root
                . '/code/frontend/',
            'templates'    => __DIR__
                . $root
                . '/code/frontend/templates/',
            'template'     => __DIR__
                . $root
                . '/code/frontend/templates/_default/',

            'config'       => __DIR__
                . $root
                . '/code/frontend/templates/_default/config.php',
            'layouts'      => __DIR__
                . $root
                . '/code/frontend/templates/_default/layouts/',
            'layout' => __DIR__
                . $root
                . '/code/frontend/templates/_default/layouts/home.html',
            'page'         => __DIR__
                . $root
                . '/code/frontend/pages/home.html',
            'assets'       => __DIR__
                . $root
                . '/code/frontend/assets/',
            'docs'         => __DIR__
                . $root
                . '/docs/',
        ];

        return $config;
    }
}
