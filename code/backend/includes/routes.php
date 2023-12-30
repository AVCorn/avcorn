<?php

/**
 * Routes configuration
 *
 * PHP version 8.2
 *
 * @param App $app The application
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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;
use App\Application\Controllers\CornController;

return function (App $app) {
    // default sets
    $avcorn   = 'avcorn';
    $default  = 'default';
    $template = '_' . $default;

    //TODO: Make a frontend paths object for this stuff
    // define directories
    $app_root           = '/../../';
    $public_dir         = '/public/';
    $frontend_dir       = '/frontend/';
    $assets_dir         = '/assets/';
    $clients_dir        = '/clients/';
    $components_dir     = '/components/';
    $templates_dir      = '/templates/';
    $template_dir       = '/' . $template . '/';
    $layouts_dir        = '/layouts/';
    $template_extension = '.html';
    $config_file        = '/config.php';
    $pages_dir          = '/pages/';
    $backend_dir        = '/backend/';
    $docs_dir           = '/docs/';

    // define paths
    $app_path        = __DIR__         . $app_root;
    $public_path     = $app_path       . $public_dir;
    $frontend_path   = $app_path       . $frontend_dir;
    $clients_path    = $frontend_path  . $clients_dir;
    $assets_path     = $frontend_path  . $assets_dir;
    $components_path = $frontend_path  . $components_dir;
    $templates_path  = $frontend_path  . $templates_dir;
    $template_path   = $templates_path . $template_dir;
    $layouts_path    = $template_path  . $layouts_dir;
    $config_path     = $template_path  . $config_file;
    $pages_path      = $frontend_path  . $pages_dir;
    $backend_path    = $app_path       . $backend_dir;
    $docs_path       = $app_path       . $docs_dir;

    // define to use client or not
    $client = $_ENV['client'] ?? false;

    // override defaults if client is set in environment
    if (
        $client
        && $client !== $default
        && $client !== $avcorn
    ) {
        $template = $client;
        $templates_dir = $clients_dir;
        $template_dir  = '/' . $template . '/';

        $templates_path = $frontend_path  . $templates_dir;
        $template_path  = $templates_path . $template_dir;
        $layouts_path   = $template_path  . $layouts_dir;
        $pages_path     = $template_path  . $pages_dir;
        $config_path    = $template_path  . $config_file;
    }

    // load config
    include_once $config_path;

    // set environment
    $config['development'] = true;
    $config['production'] = false;

    // if we are in production
    if (
        isset($_ENV['environment'])
        && $_ENV['environment'] === 'production'
    ) {
        $config['development'] = false;
        $config['production']  = true;
    }

    $config['paths'] = [
        'public'     => $public_path,
        'docs'       => $docs_path,
        'frontend'   => $frontend_path,
        'assets'     => $assets_path,
        'components' => $components_path,
        'templates'  => $templates_path,
        'template'   => $template_path,
        'layouts'    => $layouts_path,
        'extension'  => $template_extension,
        'config'     => $config_path,
        'pages'      => $pages_path,
    ];

    // commonly referred to paths
    $config['template'] = $template;
    $config['templates_path'] = $templates_dir;
    $config['template_path'] = $templates_dir . $template_dir;
    $config['assets_dir'] = $assets_dir;

    // set map for the loop
    $map = $config['map'] ?? [];

    $controller = new CornController();

    // route through the map list
    foreach ($map as $route => $page) {
        // build out config for each route
        $config['uri']    = $route;
        $config['layout'] = 'main';
        $config['page']   = $page;

        $config['paths']['layout'] = $config['paths']['layouts']
            . $config['layout']
            . $config['paths']['extension'];
        $config['paths']['page'] = $config['paths']['pages']
            . $config['page']
            . $config['paths']['extension'];

        $config['layout_path'] = $templates_dir
            . $template_dir
            . $layouts_dir
            . $config['layout']
            . $template_extension;

        /**
         * Create Route
         *
         * @var App      $app The application
         * @var Request  $req The request
         * @var Response $res The response
         *
         * @return Response
         */
        $handler = function (
            Request $req,
            Response $res,
            array $args
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $config);
        };

        // strip '/' from $route and capitalize
        $routeName = ucfirst(str_replace('/', '', $route));

        // setup for both GET and POST
        $app->get($route, $handler)->setName('get' . $routeName);
        $app->post($route, $handler)->setName('post' . $routeName);
    }

    /**
     * Favicon
     *
     * @var Request  $req  The request
     * @var Response $res  The response
     * @var array    $route The route
     *
     * @return Response
     */
    $app->get(
        '/{favicon:.*}.ico',
        function (
            Request $req,
            Response $res,
            array $route
        ) use (
            $controller,
            $config
        ) {
            return $controller->favicon($req, $res, $route, $config);
        }
    )->setName('getFavicon');

    /**
     * Assets
     *
     * @var Request  $req  The request
     * @var Response $res  The response
     * @var string   $path The path
     *
     * @return Response
     */
    $app->get(
        '/assets/{file:.*}',
        function (
            Request $req,
            Response $res,
            array $route
        ) use (
            $controller,
            $config
        ) {
            return $controller->file($req, $res, $route, $config);
        }
    )->setName('getAssetFile');

    /**
     * Template Assets
     *
     * @var Request  $req  The request
     * @var Response $res  The response
     * @var string   $path The path
     *
     * @return Response
     */
    $app->get(
        '/template/{template:.*}/assets/{file:.*}',
        function (
            Request $req,
            Response $res,
            array $route
        ) use (
            $controller,
            $config
        ) {
            return $controller->templateFile($req, $res, $route, $config);
        }
    )->setName('getTemplateAssetFile');

    /**
     * Health Check
     *
     * @var Request  $req  The request
     * @var Response $res  The response
     *
     * @return Response
     */
    $app->get(
        '/health',
        function (Request $req, Response $res) use ($controller, $config) {
            return $controller->health($req, $res, $config);
        }
    )->setName('getHealth');

    /**
     * Watcher
     *
     * @var mixed    $this The application
     * @var Request  $req  The request
     * @var Response $res  The response
     *
     * @return Response
     */
    $app->get(
        '/watch',
        function (Request $req, Response $res) use ($controller) {
            return $controller->watch($this, $req, $res);
        }
    )->setName('getWatch');

    /**
     * Documentation
     *
     * @var Request  $req  The request
     * @var Response $res  The response
     * @var string   $path The path
     *
     * @return Response
     */
    $app->get(
        '/docs{file:.*}',
        function (
            Request $req,
            Response $res,
            array $route
        ) use (
            $controller,
            $config
        ) {
            return $controller->docFile($req, $res, $route, $config);
        }
    )->setName('getDocFile');
};
