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

namespace Tests\Unit\Application\Controllers;

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use Slim\Psr7\Stream;
use App\Application\Controllers\CornController;
use Tests\Unit\TestCase;

/**
 * CornControllerTest Class
 *
 * @category TestUnit
 */
class CornControllerTest extends TestCase
{
    /**
     * Test map() Route
     *
     * @return void
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
            Response $res
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $config);
        });

        // make an HTTP request to the application
        $request = $this->createRequest('GET', '/');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test map() Route
     *
     * @return void
     */
    public function testProduction()
    {
        // Instantiate the controller
        $controller = new CornController();

        // Set up the app
        $app = $this->getAppInstance(true);

        // instantiate config
        $config = $this->createConfig();

        // Add the route to be tested
        $app->get('/', function (
            Request $req,
            Response $res
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $config);
        });

        // one time for good luck
        $request = $this->createRequest('GET', '/');
        $response = $app->handle($request);

        // re-do for cache
        $request = $this->createRequest('GET', '/');
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test map() Route with design
     *
     * @return void
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
            Response $res
        ) use (
            $controller,
            $config
        ) {
            return $controller->map($req, $res, $config);
        });

        $request = $this->createRequest('GET', '/')->withQueryParams(
            ['design' => 'lawncare']
        );
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test favicon() Route
     *
     * @return void
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
     *
     * @return void
     */
    public function testClientFaviconRoute()
    {
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
            Response $res
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
