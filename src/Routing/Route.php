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

    /** @var bool|null The name of the route. */
    private bool $isCallback = false;

    /**
    * String character that is used to split the controller callback argument.
    *
    * @var string The name of the route.
    * */
    const string SEPERATOR = "@";

    /**
     * Constructor.
     *
     * @param string $path         The path of the route.
     *
     * @param mixed $controller    The path of the route.
     *                             Can either be a string with the format 'controller@action',
     *                             or a callable.
     *
     * @param string $name         The name associated with the route.
     */
    public function __construct($path, mixed $controller, $name)
    {
        // TODO Implement callable controller functionality.
        if(is_string($controller))
        {
            if (str_contains($controller, Route::SEPERATOR)) {
                $this->isCallback = false;
                $splitString = (preg_split("/@/", $controller));
                $this->controller = $splitString[0];
                $this->action = $splitString[1];
            }else
            {
                // TODO Clean up error handling. This is here just for my own sanity.
                throw new \Exception('$controller arg should contain an "' . Route::SEPERATOR . '" character.');
            }


        }else if(is_callable($controller))
        {
            $this->isCallback = true;
            $this->controller = $controller;
        }

        $this->path       = $path;
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
     * @return string|null
     */
    public function getAction() : string|null
    {
        return $this->action;
    }

    /**
     * Get the routes controller.
     *
     * @return string|callable
     */
    public function getController() : string|callable
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

    /**
     * Returns whether this route has been defined by a callback/callable.
     *
     * @return bool.
     */
    public function isCallback() : bool
    {
        return $this->isCallback;
    }
}
