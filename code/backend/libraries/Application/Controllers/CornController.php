<?php

/**
 * Main Controller
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\Actions
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

namespace App\Application\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Application\Watcher\WatcherInterface as Watcher;

/**
 * Corn Controller Class
 *
 * @category Controller
 */
class CornController
{
    /**
     * Main Route Map Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $args   Arguments
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function map(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $args,
        array $config
    ): ResponseInterface {
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
                './',
                $value
            );
        }

        // Render the template with Twig
        $view = Twig::fromRequest($req);
        return $view->render($res, $config['paths']['page'], $config);
    }

    /**
     * Asset File Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $route  URL Parameters
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function file(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $route,
        array $config
    ): ResponseInterface {
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

    /**
     * Template Asset File Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $route  URL Parameters
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function templateFile(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $route,
        array $config
    ): ResponseInterface {
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
        return $this->lost($req, $res, $config);
    }

     /**
     * Favicon Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $route  URL Parameters
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function favicon(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $route,
        array $config
    ): ResponseInterface {
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
            return $this->lost($req, $res, $config);
        }

        // write file contents of favicon
        $favicon = file_get_contents($favicon_path);
        $res->getBody()->write($favicon);

        return $res
            ->withStatus(200)
            ->withHeader('Content-type', 'image/x-icon');
    }

     /**
     * Health Check Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $route  URL Parameters
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function docFile(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $route,
        array $config
    ): ResponseInterface {
         // check if production
        if (
            isset($_ENV['environment'])
            && $_ENV['environment'] === 'production'
        ) {
            // not found
            return $this->lost($req, $res, $config);
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
            return $this->lost($req, $res, $config);
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

    /**
     * Not Found Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function lost(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $config
    ): ResponseInterface {
        $res->getBody()->write('Not Found');
        return $res->withStatus(404);
    }

    /**
     * Watcher Check Handler
     *
     * @param ContainerInterface     $app    Application
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function watch(
        ContainerInterface $app,
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $config
    ): ResponseInterface {
        $watcher = $app->get(Watcher::class);
        $latest_file = $watcher->check(__DIR__ . '/../../');
        $latest_time = filemtime($latest_file);

        $json = '{"time": ' . (string)$latest_time . '}';
        $res->getBody()->write($json);

        return $res;
    }

    /**
     * Health Check Handler
     *
     * @param ServerRequestInterface $req    Request
     * @param ResponseInterface      $res    Response
     * @param array                  $config Configuration
     *
     * @return ResponseInterface
     */
    public function health(
        ServerRequestInterface $req,
        ResponseInterface $res,
        array $config
    ): ResponseInterface {
        $res->getBody()->write('Ok');
        return $res->withStatus(200);
    }
}
