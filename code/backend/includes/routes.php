<?php

/**
 * Routes configuration
 *
 * PHP version 8.1
 *
 * @param App $app The application
 *
 * @return void
 *
 * @phpversion >= 8.1
 * @category   CMS
 * @package    AVCorn
 * @subpackage Backend Includes
 * @author     Benjamin J. Young
 * @copyright  2023 Web Elements
 * @license    GPLv3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Watcher\WatcherInterface as Watcher;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {
    // default sets
    $default = 'default';
    $default_path = '/_' . $default . '/';
    $templates_dir = '/templates/';

    // override defaults if client is set in environment
    if (
        isset($_ENV['client'])
        && $_ENV['client'] !== 'default'
        && $_ENV['client'] !== 'avcorn'
    ) {
        $default = $_ENV['client'];
        $default_path = '/' . $default . '/';
        $templates_dir = '/clients/';
    }

    //load config
    include_once __DIR__
        . '../../../frontend/'
        . $templates_dir
        . $default_path
        . '/config.php';

    // set environment
    $config['development'] = true;
    $config['production'] = false;
    if (isset($_ENV['environment']) && $_ENV['environment'] === 'production') {
        $config['development'] = false;
        $config['production'] = true;
    }

    // commonly referred to paths
    $config['template_extension'] = '.html';
    $config['frontend_path'] = '../frontend/';
    $config['templates_root'] = $templates_dir;
    $config['layouts_root'] = '/layouts/';
    $config['pages_root'] = '/pages/';
    $config['config_root'] = '/config.php';
    $config['map'] = $config['map'] ?? [];

    // route through the map list
    foreach ($config['map'] as $route => $page) {
        // build out config for each route
        $config['uri'] = $route;
        $config['template'] = $default;
        $config['template_path'] = $config['templates_root']
            . $default_path;
        $config['layout'] = 'main';
        $config['layout_file'] = $config['layout']
            . $config['template_extension'];
        $config['layout_path'] = $config['template_path']
            . $config['layouts_root']
            . $config['layout_file'];
        $config['page'] = $page;
        $config['page_file'] = $config['page']
            . $config['template_extension'];
        $config['page_path'] = $config['template_path']
            . $config['pages_root']
            . $config['page_file'];

        // TODO: Break out main router into a class
        /**
         * Create Route
         *
         * @var App      $app The application
         * @var Response $res The response
         *
         * @return Response
         */
        $handler = function (Request $req, Response $res) use ($config) {
            // pass parameters to use
            $config['get'] = $req->getQueryParams();
            $config['post'] = $req->getParsedBody();

            // Override main config with template's
            if (
                isset($config['get']['design'])
                && isset($config['themes'][$config['get']['design']])
            ) {
                $config['template'] = $config['get']['design'];
                $config['template_path'] = $config['templates_root']
                    . $config['themes'][$config['get']['design']];
                $config['layout_path'] = $config['template_path']
                    . $config['layouts_root']
                    . $config['layout_file'];

                // Check to overwritte the page
                $overwrite_page_path = $config['template_path']
                    . $config['pages_root']
                    . $config['page_file'];
                if (file_exists($config['frontend_path'] . $overwrite_page_path)) {
                    $config['page_path'] = $overwrite_page_path;
                }

                // Check to overwrite the config
                $config_path = $config['frontend_path']
                    . $config['template_path']
                    . $config['config_root'];
                if (file_exists(__DIR__ . '../../' . $config_path)) {
                    include_once __DIR__ . '../../' . $config_path;
                }
            }

            // For template's {{ linkparams }}
            $config['linkparams'] = '';
            $urlparams = false;
            if (isset($config['template'])) {
                $config['linkparams'] .= '&design=' . $config['template'];
                $urlparams = true;
            }
            if ($urlparams) {
                $config['linkparams'] = '?a=vc' . $config['linkparams'];
            }
            if (
                isset($config['enable_params'])
                && $config['enable_params'] === false
            ) {
                $config['linkparams'] = '';
            }

            // Render the template with Twig
            $view = Twig::fromRequest($req);
            return $view->render($res, $config['page_path'], $config);
        };

        // setup for both GET and POST
        $app->get($route, $handler);
        $app->post($route, $handler);
    }

    /**
     * Health Check
     *
     * @var Response $res  The response
     *
     * @return Response
     */
    $app->get(
        '/health',
        function (Request $req, Response $res) {
            $res->getBody()->write('Ok');
            return $res;
        }
    );

    /**
     * Watcher
     *
     * @var mixed    $this The application
     * @var Response $res  The response
     *
     * @return Response
     */
    $app->get(
        '/watch',
        function (Request $req, Response $res) {
            $watcher = $this->get(Watcher::class);
            $latest_file = $watcher->check(__DIR__ . '/../../');
            $latest_time = filemtime($latest_file);

            $json = '{"time": ' . (string)$latest_time . '}';

            $res->getBody()->write($json);
            return $res;
        }
    );
};
