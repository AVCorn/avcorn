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

  $twig_config = [];
  if (isset($app->mode) && $app->mode === 'production') {
    $twig_config['cache'] = '../var/cache/templates/';
  }

  $twig = new \Twig\Environment($loader, $twig_config);

  foreach ($config['map'] as $route => $page) {

    $app->get($route, function (Request $request, Response $response, array $args) use (&$twig, $page, $config) {
      $config['get'] = $request->getQueryParams();

      if (isset($config['get']['design']) && isset($config['themes'][$config['get']['design']])) {
        require_once('../views/template/designs/'.$config['themes'][$config['get']['design']].'/config.php');
      }

      $response->getBody()->write($twig->render('pages/'.$page, $config));
      return $response;
    });
  }
};
