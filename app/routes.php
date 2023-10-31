<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
  require_once('map.php');

  $loader = new \Twig\Loader\FilesystemLoader('../pages/');
  $twig = new \Twig\Environment($loader, [
    'cache' => '../var/cache/templates/',
  ]);

  foreach ($map as $route => $page) {
    $app->get($route, function (Request $request, Response $response, array $args) use (&$twig, $page) {
      $response->getBody()->write($twig->render($page, []));
      return $response;
    });
  }
};
