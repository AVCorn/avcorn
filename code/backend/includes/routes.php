<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {
    // default sets
    $default = 'default';
    $default_path = '/_' . $default . '/';

    // override defaults if client is set in environment
    if (isset($_ENV['client']) && $_ENV['client'] !== 'default') {
        $default = $_ENV['client'];
        $default_path = '/clients/' . $default . '/';
    }

    //load config
    include_once '../frontend/templates/' . $default_path . '/config.php';

    $config['development'] = true;
    $config['production'] = false;
    if (isset($_ENV['environment']) && $_ENV['environment'] === 'production') {
        $config['development'] = false;
        $config['production'] = true;
    }

    // commonly referred to paths
    $config['template_extension'] = '.html';
    $config['frontend_path'] = '../frontend/';
    $config['templates_root'] = '/templates/';
    $config['layouts_root'] = '/layouts/';
    $config['pages_root'] = '/pages/';
    $config['config_root'] = '/config.php';

    // route through the map list
    foreach ($config['map'] as $route => $page) {
        // build out config for each route
        $config['uri'] = $route;
        $config['template'] = $default;
        $config['template_path'] = $config['templates_root'] . $default_path;
        $config['layout'] = 'main';
        $config['layout_file'] = $config['layout'] . $config['template_extension'];
        $config['layout_path'] = $config['template_path'] . $config['layouts_root'] . $config['layout_file'];
        $config['page'] = $page;
        $config['page_file'] = $config['page'] . $config['template_extension'];
        $config['page_path'] = $config['template_path'] . $config['pages_root'] . $config['page_file'];

        // create route
        $app->get($route, function (Request $request, Response $response, array $args) use ($config) {
            // pass parameters to use
            $config['get'] = $request->getQueryParams();

            // Override main config with template's
            if (isset($config['get']['design']) && isset($config['themes'][$config['get']['design']])) {
                $config['template'] = $config['get']['design'];
                $config['template_path'] = $config['templates_root'] . $config['themes'][$config['get']['design']];
                $config['layout_path'] = $config['template_path'] . $config['layouts_root'] . $config['layout_file'];

                // Check to overwritte the page
                $overwrite_page_path = $config['template_path'] . $config['pages_root'] . $config['page_file'];
                if (file_exists($config['frontend_path'] . $overwrite_page_path)) {
                    $config['page_path'] = $overwrite_page_path;
                }

                // Check to overwrite the config
                $config_path = $config['frontend_path'] . $config['template_path'] . $config['config_root'];
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
            if (isset($config['enable_params']) && $config['enable_params'] === false) {
                $config['linkparams'] = '';
            }

            // Render the template with Twig
            $view = Twig::fromRequest($request);
            return $view->render($response, $config['page_path'], $config);
        });
    }

    // health check
    $app->get('/health', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Ok");
        return $response;
    });

    function find_last_modified_file(string $dir): ?string {
        if (!is_dir($dir)) {
            throw new \ValueError('Expecting a valid directory!');
        }

        $latest = null;
        $latestTime = 0;
        foreach (scandir($dir) as $path) {
            if (!in_array($path, ['.', '..', 'cache', 'tests'], true)) {
                $filename = $dir . DIRECTORY_SEPARATOR . $path;

                if (is_dir($filename)) {
                    $directoryLastModifiedFile = find_last_modified_file($filename);

                    if (null === $directoryLastModifiedFile) {
                        continue;
                    } else {
                        $filename = $directoryLastModifiedFile;
                    }
                }

                $lastModified = filemtime($filename);
                if ($lastModified > $latestTime) {
                    $latestTime = $lastModified;
                    $latest = $filename;
                }
            }
        }

        return $latest;
    }

    // watcher
    $app->get('/watch', function (Request $request, Response $response, array $args) {
        $latest_file = find_last_modified_file(__DIR__ . '/../../');
        $latest_time = filemtime($latest_file);

        $json = '{"time": ' . (string)$latest_time . '}';

        $response->getBody()->write($json);
        return $response;
    });
};
