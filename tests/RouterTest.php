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
        $this->routeClassRouter->get($this->routeClass);

        $this->routeCallbackRouter = new Router();
        $this->routeCallback = new Route('/', function() { dump("Route Callback"); }, 'home_closure');
        $this->routeCallbackRouter->get($this->routeClass);

    }

    public function testCanGetNamedRoute()
    {
        // Tests for Routes using "controller@action" syntax
        $route = $this->routeClassRouter->getNamedRoute('home', 'GET');
        $badRoute = $this->routeClassRouter->getNamedRoute('route_will_fail', 'GET');

        //dump($this->routeClassRouter->getRoutes());
        //dd($this->routeClassRouter->getNamedRoute('home'));

        $this->assertNotNull($route, 'Route name should exist inside Router');
        $this->assertNull($badRoute, 'Route name should not exist inside Router.');
        $this->assertNotEmpty($route, 'Named route array is empty.');
        $this->assertCount(1, $route, 'Router::getNamedRoute() should return an array with a single element.');

        // Tests for Routes using "callable" syntax
        $route = $this->routeCallbackRouter->getNamedRoute('home', 'GET');

        $this->assertIsArray($route, 'Router::getNamedRoute() should return an array.');
        $this->assertInstanceOf(Route::class, $route);


        //$this->assertNotEmpty($route, 'Named route array is empty.');
        //$this->assertCount(1, $route, 'Router::getNamedRoute() should return an array with a single element.');
    }

    public function testDoesHaveNamedRouteForGet()
    {
        $router = new Router();
        $firstRoute = new Route('/', 'controller@action', 'home');
        $secondRoute = new Route('/secondRoute', 'controller@action', 'secondRoute');

        $router->get($firstRoute);

        $this->assertTrue($router->hasNamedRoute('home', 'GET'));
        //$this->assertFalse($router->hasNamedRoute('notset', 'GET'));
    }


    public function testCanAddGetRoute()
    {
        $router = new Router();
        $firstRoute = new Route('/', 'controller@action', 'home');
        $secondRoute = new Route('/secondRoute', 'controller@action', 'secondRoute');

        $router->get($firstRoute);

        // Route already added, so this should fail.
        $this->assertFalse($router->get($firstRoute));

        // Route NOT already added, so this should pass.
        $this->assertTrue($router->get($secondRoute));

        $this->assertArrayHasKey($firstRoute->getPath(), $router->getRoutes()['GET']);
    }

    public function testNoDuplicateGetRoute()
    {
        $router = new Router();
        $route1 = new Route('/', "controller@action", 'home');
        $route2 = new Route('/', "controller@action", 'home');

        $router->get($route1);
        $router->get($route2);

        $this->assertFalse($router->get($route1));

        $this->assertArrayHasKey($route1->getPath(), $router->getRoutes()['GET']);
    }

    public function testCanGetCurrentRequest() : void
    {
        $router = new Router();
        $this->assertNotNull($router->getRequest());
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Request::class, $router->getRequest());
    }

}
