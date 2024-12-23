<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Espresso\Container;

final class ContainerTest extends TestCase
{
    public $container = NULL;

    public function setup() : void
    {
        $this->container = new Container();
    }

    public function testContainerHasBooted(): void
    {
        $this->assertTrue($this->container->hasBooted());
    }

    public function testCanGetServiceCount(): void
    {
        $this->assertIsInt($this->container->getServiceCount());

        $this->assertEquals(
            $this->container->getServiceCount(),
            1
        );
    }

    public function testHasRouterService(): void
    {
        $this->assertTrue($this->container->has('Router'));

        $this->assertArrayHasKey(
            'Router',
            $this->container->getServices(),
            "Instance of " . \Espresso\Service\RouterService::class . " not found"
        );
    }

    public function testCanGetRouterService()
    {
        $this->assertTrue(
            $this->container->has('Router'),
            "Instance of " . 'Router'. " not found"
        );

        $this->assertInstanceOf(
            \Espresso\Service\RouterService::class,
            $this->container->get('Router'),
            "Instance of " . 'Router'. " not found"
        );
    }

    public function testCanGetInstanceOfRouterService()
    {
        $this->assertInstanceOf(
            \Espresso\Service\RouterService::class,
            $this->container->getInstance('Router'),
            "Instance of " . 'Router'. " not found"
        );
    }

    //public function testCanGetAppService()
    //{
        //$this->assertTrue(
            //$this->container->has('Espresso'),
            //"Instance of " . 'Espresso'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\AppService::class,
            //$this->container->getInstance('Espresso'),
            //"Instance of " . 'Espresso'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\AppService::class,
            //$this->container->get('Espresso'),
            //"Instance of " . 'Espresso'. " not found"
        //);
    //}

    //public function testCanGetTwigService()
    //{
        //$this->assertTrue(
            //$this->container->has('Twig'),
            //"Instance of " . 'Twig'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\TwigService::class,
            //$this->container->getInstance('Twig'),
            //"Instance of " . 'Twig'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\TwigService::class,
            //$this->container->get('Twig'),
            //"Instance of " . 'Twig'. " not found"
        //);
    //}

    //public function testCanGetRouterService()
    //{
        //$this->assertTrue(
            //$this->container->has('Router'),
            //"Instance of " . 'Router'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\RouterService::class,
            //$this->container->getInstance('Router'),
            //"Instance of " . 'Router'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\RouterService::class,
            //$this->container->get('Router'),
            //"Instance of " . 'Router'. " not found"
        //);
    //}

    //public function testCanGetDatabaseService()
    //{
        //$this->assertTrue(
            //$this->container->has('Database'),
            //"Instance of " . 'Database'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\DatabaseService::class,
            //$this->container->getInstance('Database'),
            //"Instance of " . 'Database'. " not found"
        //);

        //$this->assertInstanceOf(
            //\Espresso\Service\DatabaseService::class,
            //$this->container->get('Database'),
            //"Instance of " . 'Database'. " not found"
        //);
    //}

    //public function testCanGetDoctrineService()
    //{
        //$this->assertTrue(
            //$this->container->has('Doctrine'),
            //"Instance of " . 'Doctrine'. " not found"
        //);

        //$this->assertInstanceOf(
            //\App\Service\DoctrineService::class,
            //$this->container->getInstance('Doctrine'),
            //"Instance of " . 'Doctrine'. " not found"
        //);

        //$this->assertInstanceOf(
            //\App\Service\DoctrineService::class,
            //$this->container->get('Doctrine'),
            //"Instance of " . 'Doctrine'. " not found"
        //);
    //}
}
