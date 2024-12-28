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

        $this->testRoute = new Route('home', '/', 'TestController', 'TestAction', 'GET');
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
}
