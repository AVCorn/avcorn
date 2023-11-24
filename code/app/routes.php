<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
  require_once('../views/config/config.php');

  $loader = new \Twig\Loader\FilesystemLoader('../views/');

  // Cache pages only on production
  $twig_config = [];
  if (isset($app->mode) && $app->mode === 'production') {
    $twig_config['cache'] = '../var/cache/templates/';
  }

  $twig = new \Twig\Environment($loader, $twig_config);

  // route through the map list
  foreach ($config['map'] as $route => $page) {

    $app->get($route, function (Request $request, Response $response, array $args) use (&$twig, $page, $config) {
      $config['get'] = $request->getQueryParams();

      // Override main config with template's
      if (isset($config['get']['design']) && isset($config['themes'][$config['get']['design']])) {
        $config_path = '../views/template/designs/'.$config['themes'][$config['get']['design']].'/config.php';

        if (file_exists($config_path)) {
          require_once($config_path);
        }
      }

      // For template's {{ linkparams }}
      $config['linkparams'] = '';
      $urlparams = false;
      if (isset($config['get']['design'])) {
        $config['linkparams'] .= '&design=' . $config['get']['design'];
        $urlparams = true;
      }
      if ($urlparams) {
        $config['linkparams'] = '?a=vc'.$config['linkparams'];
      }

      // Render the template with Twig
      $response->getBody()->write($twig->render('pages/'.$page, $config));
      return $response;
    });
  }
};
