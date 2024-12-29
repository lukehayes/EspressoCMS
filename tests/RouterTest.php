<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Routing\Router;
use Espresso\Routing\Route;

final class RouterTest  extends TestCase
{
    public $router = NULL;

    public $testRoute = NULL;

    public function setup() : void
    {
        $this->router = new Router();
        $this->testRoute = new Route('/', 'TestController', 'TestAction', 'home');

        $this->router->get($this->testRoute);
    }

    public function testDoesHaveNamedRouteForGet()
    {
        $this->assertTrue($this->router->hasNamedRoute('home', 'GET'));
        $this->assertFalse($this->router->hasNamedRoute('notset', 'GET'));
    }

    public function testCanGetNamedRoute()
    {
        $route = $this->router->getNamedRoute('home', 'GET');

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

}
