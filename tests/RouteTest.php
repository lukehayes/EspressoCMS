<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Route;

final class RouteTest  extends TestCase
{
    public $router = NULL;

    public $testRoute = NULL;

    public function setup() : void
    {
        // TODO Implement Router Tests.

        $this->testRoute = new Route('/', 'TestController', 'TestAction', 'home');
    }

    public function testCanGetRouteName() : void
    {
        $this->assertEquals($this->testRoute->getName(), 'home');
    }

    public function testCanGetRoutePath() : void
    {
        $this->assertEquals($this->testRoute->getPath(), '/');
    }

    public function testCanGetRouteControllerString() : void
    {
        $this->assertEquals($this->testRoute->getController(), 'TestController');
    }

    public function testCanGetRouteActionString() : void
    {
        $this->assertEquals($this->testRoute->getAction(), 'TestAction');
    }

    public function testRouteObjectIsCallback() : void
    {
        $callbackRoute = new Route('/', 'Controller@action', 'home');

        $this->assertNotNull($callbackRoute->isCallback());
    }
}
