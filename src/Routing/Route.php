<?php
namespace Espresso\Routing;

/**
 * Espresso\Routing\Route is a class for representing an endpoint inside the application.
 *
 * @example $route = new Route('home','/', 'HomeController', 'index');
 */
class Route
{
    /**
     * @var string|null The path of the route. */
    private $path = null;

    /** @var string|null The action of the route. */
    private $action = null;

    /** @var string|null The controller of the route. */
    private $controller = null;

    /** @var string|null The name of the route. */
    private $name = null;

    /** @var array */
    private $methods = [];

    /**
     * Constructor.
     *
     * @param string $path          The path of the route.
     * @param string $controller    The path of the route.
     * @param string $action        The action of the route.
     * @param string $name          The name associated with the route.
     */
    public function __construct($path, $controller, $action, $name)
    {
        $this->path       = $path;
        $this->action     = $action;
        $this->controller = $controller;
        $this->name       = $name;
    }

    /**
     * Get the routes path.
     *
     * @return string
     */
    public function getPath() : ?string
    {
        return $this->path;
    }

    /**
     * Get the routes action.
     *
     * @return string
     */
    public function getAction() : ?string
    {
        return $this->action;
    }

    /**
     * Get the routes controller.
     *
     * @return string
     */
    public function getController() : ?string
    {
        return $this->controller;
    }

    /**
     * Get the routes associated name.
     *
     * @return string.
     */
    public function getName() : ?string
    {
        return $this->name;
    }
}
