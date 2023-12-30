<?php

/**
 * Public index route.
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Index
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

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
use App\Application\Middleware\FormMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set _GET client to _ENV client
if (isset($_GET['client'])) {
    $_ENV['client'] = $_GET['client'];
}

// Enable cache on Production
if (isset($_ENV['production'])) {
    $containerBuilder->enableCompilation(__DIR__ . '/cache');
}

// Set up settings
$settings = include __DIR__ . '/source/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = include __DIR__ . '/source/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = include __DIR__ . '/source/repositories.php';
$repositories($containerBuilder);

// Set up watcher
if (!isset($app->mode) || $app->mode !== 'production') {
    $watcher = include __DIR__ . '/source/watcher.php';
    $watcher($containerBuilder);
}

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

// Set view on container
$container->set('view', $twig);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Register middleware
$middleware = include __DIR__ . '/source/middleware.php';
$middleware($app);

// Register forms
$forms = include __DIR__ . '/source/forms.php';
$forms($app);

// Register routes
$routes = include __DIR__ . '/source/routes.php';
$routes($app);

/**
 * Settings
 *
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
$errorHandler = new HttpErrorHandler(
    $callableResolver,
    $responseFactory
);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler(
    $request,
    $errorHandler,
    $displayErrorDetails
);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(
    $displayErrorDetails,
    $logError,
    $logErrorDetails
);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
