<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Route;

final class RoutControllerTest  extends TestCase
{
    public $router        = NULL;
    public $routeController   = NULL;

    public function setup() : void
    {
        $this->routeController = new Route('/', 'TestController@index', 'home');
    }

    public function testCanGetRouteName() : void
    {
        $this->assertEquals($this->routeController->getName(), 'home');
    }

    public function testCanGetRoutePath() : void
    {
        $this->assertEquals($this->routeController->getPath(), '/');
    }

    public function testCanGetRouteControllerString() : void
    {
        $this->assertEquals($this->routeController->getController(), 'TestController');
    }

    public function testCanGetRouteActionString() : void
    {
        $this->assertEquals($this->routeController->getAction(), 'index');
    }
}
