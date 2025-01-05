<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Router;
use Espresso\Routing\Route;

final class RouteTest  extends TestCase
{
    public function setup() : void
    {
    }

    public function testCanGetRouteControllerName()
    {
        $route = new Route('/', 'controller@index', 'home');

        $this->assertEquals('controller', $route->getController());
    }

    public function testCanGetRouteControllerAction()
    {
        $route = new Route('/', 'controller@index', 'home');

        $this->assertEquals('index', $route->getAction());
    }

    public function testCanGetRouteControllerPath()
    {
        $route = new Route('/', 'controller@index', 'home');

        $this->assertEquals('index', $route->getAction());
    }

    public function testRouteIsCallable()
    {
        $route = new Route('/', 'controller@index', 'home');
        $callbackRoute = new Route('/', function() {}, 'home');

        $this->assertFalse($route->isCallback());

        $this->assertTrue($callbackRoute->isCallback());
    }
}
