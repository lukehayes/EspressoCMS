<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Route;

final class RouteCallbackTest  extends TestCase
{
    public $router        = NULL;
    public $routeCallable = NULL;

    public function setup() : void
    {
        $this->routeCallable = new Route('/', function() {} , 'home');
    }

    public function testCanGetRouteName() : void
    {
        $this->assertEquals($this->routeCallable->getName(), 'home');
    }

    public function testCanGetRoutePath() : void
    {
        $this->assertEquals($this->routeCallable->getPath(), '/');
    }

    public function testCanGetRouteControllerString() : void
    {
        $this->assertIsCallable($this->routeCallable->getController());
    }

    public function testRouteObjectIsCallback() : void
    {
        $callbackRoute = new Route('/', 'Controller@action', 'home');

        $this->assertNotNull($callbackRoute->isCallback());
    }
}
