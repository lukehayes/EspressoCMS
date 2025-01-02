<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Router;
use Espresso\Routing\Route;

final class RouterTest  extends TestCase
{
    public $routeClassRouter = NULL;
    public $routeClass       = NULL;

    public $routeCallbackRouter = NULL;
    public $routeCallback       = NULL;

    public function setup() : void
    {
        $this->routeClassRouter = new Router();
        $this->routeClass = new Route('/', 'TestController@index', 'home');

        $this->routeCallbackRouter = new Router();
        $this->routeCallback = new Route('/', function() { dump("Route Callback"); }, 'home');

        $this->routeClassRouter->get($this->routeClass);
    }

    public function testDoesHaveNamedRouteForGet()
    {
        $this->assertTrue($this->routeClassRouter->hasNamedRoute('home', 'GET'));
        $this->assertFalse($this->routeClassRouter->hasNamedRoute('notset', 'GET'));

        $this->assertTrue($this->routeClassRouter->hasNamedRoute('home', 'GET'));
        $this->assertFalse($this->routeClassRouter->hasNamedRoute('notset', 'GET'));
    }

    public function testCanGetNamedRoute()
    {
        // Tests for Routes using "controller@action" syntax
        $route = $this->routeClassRouter->getNamedRoute('home', 'GET');

        $this->assertIsArray($route, 'Router::getNamedRoute() should return an array.');
        $this->assertNotEmpty($route, 'Named route array is empty.');
        $this->assertCount(1, $route, 'Router::getNamedRoute() should return an array with a single element.');

        // Tests for Routes using "callable" syntax
        $route = $this->routeCallbackRouter->getNamedRoute('home', 'GET');

        $this->assertIsArray($route, 'Router::getNamedRoute() should return an array.');
        $this->assertNotEmpty($route, 'Named route array is empty.');
        $this->assertCount(1, $route, 'Router::getNamedRoute() should return an array with a single element.');
    }

    public function testCanAddGetRoute()
    {
        $newRoute = new Route('other', '/other', 'OtherController', 'OtherAction');

        // Route already added, so this should fail.
        $this->assertFalse($this->router->get($this->testRoute));

        // Route NOT already added, so this should pass.
        $this->assertTrue($this->router->get($newRoute));

        $this->assertArrayHasKey($newRoute->getPath(), $this->router->getRoutes()['GET']);

        $this->assertArrayHasKey($newRoute->getPath(), $this->router->getRoutes()['GET']);
    }

    public function testNoDuplicateGetRoute()
    {
        $this->assertFalse($this->router->get($this->testRoute));

        $this->assertArrayHasKey($this->testRoute->getPath(), $this->router->getRoutes()['GET']);
    }

    public function testCanGetCurrentRequest() : void
    {
        $this->assertNotNull($this->router->getRequest());
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Request::class, $this->router->getRequest());
    }

}
