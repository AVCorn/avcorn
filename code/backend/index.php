<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (isset($_ENV['production'])) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/cache');
}

// Set up settings
$settings = include __DIR__ . '/includes/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = include __DIR__ . '/includes/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = include __DIR__ . '/includes/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Cache pages only on production
$twig_config = [];
if (isset($app->mode) && $app->mode === 'production') {
    $twig_config['cache'] = './cache/templates/';
}

// Create Twig
$twig = Twig::create('../frontend/', $twig_config);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Register middleware
$middleware = include __DIR__ . '/includes/middleware.php';
$middleware($app);

// Register routes
$routes = include __DIR__ . '/includes/routes.php';
$routes($app);

/**
 * @var SettingsInterface $settings
 */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);