<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
  require_once('../view/templates/_default/config.php');
  $config['view_extension'] = '.html';
  $config['view_path'] = '../view/';
  $config['templates_root'] = '/templates/';
  $config['layouts_root'] = '/layouts/';
  $config['pages_root'] = '/pages/';
  $config['config_root'] = '/config.php';

  $loader = new \Twig\Loader\FilesystemLoader('../view/');

  // Cache pages only on production
  $twig_config = [];
  if (isset($app->mode) && $app->mode === 'production') {
    $twig_config['cache'] = './var/cache/templates/';
  }

  $twig = new \Twig\Environment($loader, $twig_config);

  // route through the map list
  foreach ($config['map'] as $route => $page) {
    $config['uri'] = $route;
    $config['template'] = 'default';
    $config['template_path'] = $config['templates_root'].'/_default/';
    $config['layout'] = 'main';
    $config['layout_file'] = $config['layout'].$config['view_extension'];
    $config['layout_path'] = $config['template_path'].$config['layouts_root'].$config['layout_file'];
    $config['page'] = $page;
    $config['page_file'] = $config['page'].$config['view_extension'];
    $config['page_path'] = $config['template_path'].$config['pages_root'].$config['page_file'];

    $app->get($route, function (Request $request, Response $response, array $args) use (&$twig, $page, $config) {
      $config['get'] = $request->getQueryParams();

      // Override main config with template's
      if (isset($config['get']['design']) && isset($config['themes'][$config['get']['design']])) {
        $config['template'] = $config['get']['design'];
        $config['template_path'] = $config['templates_root'].$config['themes'][$config['get']['design']];
        $config['layout_path'] = $config['template_path'].$config['layouts_root'].$config['layout_file'];

        // Check for overwritten page
        $overwrite_page_path = $config['template_path'].$config['pages_root'].$config['page_file'];
        if (file_exists($config['view_path'].$overwrite_page_path)) {
          $config['page_path'] = $overwrite_page_path;
        }

        $config_path = $config['view_path'].$config['template_path'].$config['config_root'];

        if (file_exists($config_path)) {
          require_once($config_path);
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
        $config['linkparams'] = '?a=vc'.$config['linkparams'];
      }
      if (isset($config['enable_params']) && $config['enable_params'] === false) {
        $config['linkparams'] = '';
      }
      
      // Render the template with Twig
      $response->getBody()->write($twig->render($config['page_path'], $config));
      return $response;
    });
  }
};
