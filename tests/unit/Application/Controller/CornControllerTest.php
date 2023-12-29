<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use Slim\Psr7\Stream;
use App\Application\Controllers\CornController;
use Tests\TestCase;

class CornControllerTest extends TestCase {

  public function testMapRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->map($req, $res, $args, $config);
    });

    $request = $this->createRequest('GET', '/');
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testDesignRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // override path
    $root = '/../../../../';
    $config['paths']['config'] = __DIR__
        . $root
        . '/code/frontend/templates/examples/categories/lawncare/config.php';

    // Add the route to be tested
    $app->get('/', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->map($req, $res, $args, $config);
    });

    $request = $this->createRequest('GET', '/')->withQueryParams(['design' => 'lawncare']);
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testClientFaviconRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // set client
    $_ENV['client'] = 'webelements';

    // override path
    $root = '/../../../../';
    $config['paths']['template'] = __DIR__
        . $root
        . '/code/frontend/clients/webelements/';

    $request = $this->createRequest('GET', '/favicon.ico');
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
    
    // unset client
    unset($_ENV['client']);
  }

  public function testFaviconRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest('GET', '/favicon.ico');
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testLostFaviconRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest('GET', '/favicon-lost.ico');
    $response = $app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest(
        'GET',
        '/assets/images/nutty/nutty.png'
    );
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testClientFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // set client
    $_ENV['client'] = 'webelements';

    // override path
    $root = '/../../../../';
    $config['paths']['template'] = __DIR__
        . $root
        . '/code/frontend/clients/webelements/';

    // Add the route to be tested
    $app->get('/test/assets/{file:.*}', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->file($req, $res, $args, $config);
    });

    $request = $this->createRequest(
        'GET',
        '/test/assets/images/logos/logo.png'
    );
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());

    // unset client
    unset($_ENV['client']);
  }

  public function testLostFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest(
        'GET',
        '/assets/images/lost/lost.png'
    );
    $response = $app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testTemplateFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/test/template/{template:.*}/assets/{file:.*}', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->templateFile($req, $res, $args, $config);
    });

    $request = $this->createRequest(
        'GET',
        '/test/template/marketing/assets/images/nutty.png'
    );
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testLostTemplateFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/test/template/{template:.*}/assets/{file:.*}', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->templateFile($req, $res, $args, $config);
    });

    $request = $this->createRequest(
        'GET',
        '/test/template/marketing/assets/images/lost.png'
    );
    $response = $app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testDocFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/test/docs{file:.*}', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->docFile($req, $res, $args, $config);
    });

    $request = $this->createRequest(
        'GET',
        '/test/docs/'
    );
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testLostDocFileRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/test/docs{file:.*}', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->docFile($req, $res, $args, $config);
    });

    $request = $this->createRequest(
        'GET',
        '/test/docs/lost.html'
    );
    $response = $app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHealthRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest('GET', '/health');
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testWatchRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    $request = $this->createRequest('GET', '/watch');
    $response = $app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testLostRoute() {
    // Instantiate the controller
    $controller = new CornController();

    // Set up the app
    $app = $this->getAppInstance();

    // instantiate config
    $config = $this->createConfig();

    // Add the route to be tested
    $app->get('/404', function (
        Request $req,
        Response $res,
        array $args
    ) use ($controller, $config) {
        return $controller->lost($req, $res, $args, $config);
    });

    $request = $this->createRequest('GET', '/404');
    $response = $app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }
}
