<?php

/**
 * Test the Action class
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Tests\Application\Actions
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace Tests\Application\Controllers;

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use Slim\Psr7\Stream;
use App\Application\Controllers\CornController;
use Tests\TestCase;

/**
 * CornControllerTest Class
 *
 * @category TestUnit
 */
class CornControllerTest extends TestCase
{
  /**
   * Test map() Route
   */
    public function testMapRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $args, $config);
        });

        $request = $this->createRequest('GET', '/');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test map() Route with design
     */
    public function testDesignRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $args, $config);
        });

        $request = $this->createRequest('GET', '/')->withQueryParams(
            ['design' => 'lawncare']
        );
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test favicon() Route
     */
    public function testFaviconRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/favicon.ico');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test favicon() Route with client
     */
    public function testClientFaviconRoute()
    {
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

    /**
     * Test favicon() lost Route
     */
    public function testLostFaviconRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/favicon-lost.ico');
        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test file() Route
     */
    public function testFileRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest(
            'GET',
            '/assets/images/nutty/nutty.png'
        );
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test file() Route with client
     */
    public function testClientFileRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
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

    /**
     * Test file() lost Route
     */
    public function testLostFileRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest(
            'GET',
            '/assets/images/lost/lost.png'
        );
        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test templateFile() Route
     */
    public function testTemplateFileRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->templateFile($req, $res, $args, $config);
        });

        $request = $this->createRequest(
            'GET',
            '/test/template/marketing/assets/images/nutty.png'
        );
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test templateFile() lost Route
     */
    public function testLostTemplateFileRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->templateFile($req, $res, $args, $config);
        });

        $request = $this->createRequest(
            'GET',
            '/test/template/marketing/assets/images/lost.png'
        );
        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test docFile() Route
     */
    public function testDocFileRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->docFile($req, $res, $args, $config);
        });

        $request = $this->createRequest(
            'GET',
            '/test/docs/'
        );
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test docFile() lost Route
     */
    public function testLostDocFileRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->docFile($req, $res, $args, $config);
        });

        $request = $this->createRequest(
            'GET',
            '/test/docs/lost.html'
        );
        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test health() Route
     */
    public function testHealthRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/health');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test watch() Route
     */
    public function testWatchRoute()
    {
        // Set up the app
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/watch');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test lost() Route
     */
    public function testLostRoute()
    {
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
        ) use (
            $controller,
            $config
        ) {
            return $controller->lost($req, $res, $config);
        });

        $request = $this->createRequest('GET', '/404');
        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
