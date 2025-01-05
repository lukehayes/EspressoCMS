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
        $router = new Router();
        
        $route1 = new Route('/', "controller@action", 'home');
        $route2 = new Route('/route_two', "controller@action", 'route_two');

        $router->get($route1);
        $router->get($route2);

        $route = $router->getNamedRoute('home');

        $this->assertNotNull($route, 'Route name should exist inside Router');

        $this->assertNull($router->getNamedRoute('route_does_not_exist'), 'Route name should not exist inside Router.');

        $this->assertInstanceOf(Route::class, $route);
    }

    public function testDoesHaveNamedRouteForGet()
    {
        $router = new Router();
        $firstRoute = new Route('/', 'controller@action', 'home');

        $router->get($firstRoute);

        $this->assertTrue($router->hasNamedRoute('home', 'GET'));
        $this->assertFalse($router->hasNamedRoute('notset', 'GET'));
    }

    public function testCanGetNamedRouteForPost() : void
    {
        $router = new Router();
        $route = new Route("/login", 'controller@login', 'login');

        $router->post($route);

        $route = $router->getNamedRoute('login', 'POST');

        $this->assertNotNull($route, 'POST Route name should exist inside Router');

        $this->assertNull($router->getNamedRoute('post_route_does_not_exist'), 'POST Route name should not exist inside Router.');

        $this->assertInstanceOf(Route::class, $route);
    }

    public function testDoesHaveNamedRouteForPost()
    {
        $router = new Router();
        $firstRoute = new Route('/login', 'controller@action', 'login');

        $router->post($firstRoute);

        $this->assertTrue($router->hasNamedRoute('login', 'POST'));
        $this->assertFalse($router->hasNamedRoute('notset', 'POST'));
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
