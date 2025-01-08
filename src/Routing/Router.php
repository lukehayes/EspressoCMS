<?php
namespace Espresso\Routing;

use Espresso\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Router
{
    /** @var array|null $routes */
    private array|null $routes = null;

    /** @var Request $requet */
    private Request $request;

    public function __construct()
    {
        $this->routes['GET']  = [];
        $this->routes['POST'] = [];
        $this->request = Request::createFromGlobals();
    }

    /**
     * Routes getter function.
     *
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * Check to see if there is an available route for the current URI.
     *
     * @return bool
     */
    public function routeAvailable() : bool
    {
        $uri    = $this->request->server->get('REQUEST_URI');
        $method = $this->request->server->get('REQUEST_METHOD');
        $routes = $this->routes[$method];

        return array_key_exists($uri, $routes) ? true : false;
    }

    /**
     * Check if a route is available to the application and then load it.
     * If the route is not available then return a 404.
     *
     * @return void.
     */
    public function resolveRoute()
    {
        $uri    = $this->request->server->get('REQUEST_URI');
        $method = $this->request->server->get('REQUEST_METHOD');

        // TODO Routing only really works for controllers and actions.
        //      Need to implement routing for APIs that return JSON. 
        //
        //      Implement callback etc.
        if(str_contains($uri, 'api'))
        {
            // TODO Set JSON headers etc.
            $response = new JsonResponse("API ENDPOINT");
            $response->setData(['a'=>1, 'b'=> 2]);
            $response->send();
        }else
        {
            // TODO Need to check for Closure style routes.
            if($this->routeAvailable())
            {
                $routeObject = $this->routes[$method][$uri];

                // Is the route defined as a closure or with a string?
                if($routeObject->isCallback())
                {
                    $routeObject->getController(
                    )($this->request);
                }else
                {
                    // If we reach here then the route is defined as a string
                    // with the format 'controllername@action'.
                    $controller  = new ($routeObject->getController());
                    $action      = $routeObject->getAction();
                    $controller->$action(
                        $this->request
                    );
                }
            }else
            {
                // TODO Implement a 'prettier' solution than a text 404.
                $response = new Response('No Route Found', Response::HTTP_NOT_FOUND);
                $response->send();
            }
        }
    }

    /**
     * Add a GET route to the router. If the key already
     * exists, then false is returned.
     *
     * @param Route $route.
     *
     * @return bool.
     */
    public function get(Route $route) : bool
    {
        $method = 'GET';

        if(array_key_exists($route->getPath(), $this->routes[$method]))
            return false;

        $this->routes[$method][$route->getPath()] = $route;
            return true;
    }

    /**
     * Does a route with a specific name exist?
     *
     * @param string $name.
     * @param string $method. Defaults to GET.
     *
     *@return bool.
     */
    public function hasNamedRoute(string $name, string $method = "GET") : bool
    {
        return !!$this->getNamedRoute($name, $method);
    }

    /**
     * Does a route with a specific name exist?
     *
     * @param string $name.
     * @param string $method. Defaults to GET.
     *
     * @return ?Route
     */
    public function getNamedRoute(string $name, $method = 'GET') : ?Route
    {
        $route = array_filter($this->routes[$method], function($r) use ($name)
        {
            return $r->getName() == $name;
        });

        $isArrayAndNotEmpty = fn($r) => is_array($r) && count($r) > 0;

        return $isArrayAndNotEmpty($route) ? array_shift($route) : null;
    }

    /**
     * Add a POST route to the router. If the key already
     * exists, then false is returned.
     *
     * @param Route $route.
     *
     * @return bool.
     */
    public function post(Route $route) : bool
    {
        $method = 'POST';

        if(array_key_exists($route->getPath(), $this->routes[$method]))
            return false;

        $this->routes[$method][$route->getPath()] = $route;
            return true;
    }

    /**
    * Is the current REQUEST_METHOD equal to GET?
    *
    * @return bool.
    */
    public function isGet() : bool
    {
        return $this->request->server->get('REQUEST_METHOD') === 'GET';
    }

    /**
    * Is the current REQUEST_METHOD equal to POST?
    *
    * @return bool.
    */
    public function isPost() : bool
    {
        return $this->request->server->get('REQUEST_METHOD') === 'POST';
    }

    /**
    * Get the current request.
    *
    * @return Request.
    */
    public function getRequest() : Request
    {
        return $this->request;
    }
}
