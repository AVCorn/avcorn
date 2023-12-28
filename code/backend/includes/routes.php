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
use App\Application\Watcher\WatcherInterface as Watcher;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

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
    $template_dir        = '/' . $template . '/';
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

        // TODO: Break out main router into a class
        /**
         * Create Route
         *
         * @var App      $app The application
         * @var Request  $req The request
         * @var Response $res The response
         *
         * @return Response
         */
        $handler = function (Request $req, Response $res) use ($config) {
            // pass parameters to use
            $get  = $req->getQueryParams();
            $post = $req->getParsedBody();

            $config['get']  = $get;
            $config['post'] = $post;

            $design = $get['design'] ?? false;
            $themes = $config['themes'];

            // Override main config with template's
            if ($design && isset($themes[$design])) {
                // override template
                $config['template'] = $design;

                $old_temp_dir = $config['template_path'];
                $new_temp_dir = $config['templates_path']
                    . '/' . $themes[$design] . '/';

                // replace $old_temp_dir with $new_temp_dir in paths
                foreach ($config['paths'] as $key => $value) {
                    $config['paths'][$key] = str_replace(
                        $old_temp_dir,
                        $new_temp_dir,
                        $value
                    );
                }

                // now do it for the other usage
                $config['template_path'] = str_replace(
                    $old_temp_dir,
                    $new_temp_dir,
                    $config['template_path']
                );
                $config['layout_path'] = str_replace(
                    $old_temp_dir,
                    $new_temp_dir,
                    $config['layout_path']
                );

                // Check to overwrite the config
                $config_path = $config['paths']['config'];
                if (file_exists($config_path)) {
                    include_once $config_path;
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

            // grab twig render director
            $twig_dir = $config['paths']['frontend'];

            // remove $twig_dir from ever $config['paths'] child
            foreach ($config['paths'] as $key => $value) {
                $config['paths'][$key] = str_replace(
                    $twig_dir,
                    '.',
                    $value
                );
            }

            // Render the template with Twig
            $view = Twig::fromRequest($req);
            return $view->render($res, $config['paths']['page'], $config);
        };

        // setup for both GET and POST
        $app->get($route, $handler);
        $app->post($route, $handler);
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
        function (Request $req, Response $res, array $route) use ($config) {
            // amend '.ico' to uri
            $file = $route['favicon'] . '.ico';

            // default favicon path
            $favicon_path = $config['paths']['assets']
                . '/images/icons/'
                . $file;

            // figure out which favicon to use
            if (isset($_ENV['client'])) {
                $client_path = $config['paths']['template']
                    . $config['assets_dir']
                    . '/images/icons/'
                    . $file;

                if (file_exists($client_path)) {
                    $favicon_path = $client_path;
                }
            }

            // check for favicon existence
            if (!file_exists($favicon_path)) {
                // respond with 404
                $res->getBody()->write('Not Found');
                return $res->withStatus(404);
            }

            // write file contents of favicon
            $favicon = file_get_contents($favicon_path);
            $res->getBody()->write($favicon);

            return $res
                ->withStatus(200)
                ->withHeader('Content-type', 'image/x-icon');
        }
    );

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
        function (Request $req, Response $res, array $route) use ($config) {
            // set file path
            $file = $route['file'];

            $assets_file = $config['paths']['assets'] . $file;
            $client_file = $config['paths']['template']
                . $config['assets_dir']
                . $file;
            $use_file = $assets_file;

            if (file_exists($client_file)) {
                // overwrite and use the client assest
                $use_file = $client_file;
            } elseif (file_exists($assets_file)) {
                // use the default asset
                $use_file = $assets_file;
            } else {
                // Not found
                $res->getBody()->write('Not Found');
                return $res->withStatus(404);
            }

            // write file contents
            $file_contents = file_get_contents($use_file);
            $res->getBody()->write($file_contents);

            // get file type of $file
            $file_type = mime_content_type($use_file);

            // get the file extesion
            $file_ext = pathinfo($use_file, PATHINFO_EXTENSION);

            if ($file_ext === 'css') {
                $file_type = 'text/css';
            } elseif ($file_ext === 'js') {
                $file_type = 'text/javascript';
            }

            return $res
                ->withHeader('Content-type', $file_type)
                ->withStatus(200);
        }
    );

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
        function (Request $req, Response $res, array $route) use ($config) {
            // set file path
            $file = $config['paths']['templates']
                . $config['themes'][$route['template']]
                . $config['assets_dir']
                . $route['file'];

            // check for file existence
            if (file_exists($file)) {
                // write file contents
                $file_contents = file_get_contents($file);
                $res->getBody()->write($file_contents);

                // get file type of $file
                $file_type = mime_content_type($file);

                return $res
                    ->withHeader('Content-type', $file_type)
                    ->withStatus(200);
            }

            // Not found
            $res->getBody()->write('Not Found');
            return $res->withStatus(404);
        }
    );

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
        function (Request $req, Response $res) {
            $res->getBody()->write('Ok');

            return $res;
        }
    );

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
        function (Request $req, Response $res) {
            $watcher = $this->get(Watcher::class);
            $latest_file = $watcher->check(__DIR__ . '/../../');
            $latest_time = filemtime($latest_file);

            $json = '{"time": ' . (string)$latest_time . '}';
            $res->getBody()->write($json);

            return $res;
        }
    );


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
        function (Request $req, Response $res, array $route) use ($config) {
            // check if production
            if (
                isset($_ENV['environment'])
                && $_ENV['environment'] === 'production'
            ) {
                return;
            }

            $file = $route['file'] ?? '';

            // check if $file is '/docs' or '/docs/coverage'
            if (
                $file === ''
                || $file === '/'
                || $file === '/coverage'
                || $file === '/coverage/'
            ) {
                $file .= '/index.html';
            }

            // set file path
            $doc_file = $config['paths']['docs'] . $file;

            if (!file_exists($doc_file)) {
                // Not found
                $res->getBody()->write('Not Found');
                return $res->withStatus(404);
            }

            // write file contents
            $file_contents = file_get_contents($doc_file);
            $res->getBody()->write($file_contents);

            // get file type of $file
            $file_type = mime_content_type($doc_file);

            // get the file extesion
            $file_ext = pathinfo($doc_file, PATHINFO_EXTENSION);

            if ($file_ext === 'css') {
                $file_type = 'text/css';
            } elseif ($file_ext === 'js') {
                $file_type = 'text/javascript';
            }

            return $res
                ->withHeader('Content-type', $file_type)
                ->withStatus(200);
        }
    );
};
