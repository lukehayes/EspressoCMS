<?php
namespace Espresso\Service;

use Espresso\Service\Service;
use Espresso\Routing\Router;

class RouterService extends Service
{
    /**
     * The instance of a service.
     *
     * @var Router | null
     * */
    public ?Router $service = NULL;

    public function __construct()  {}

    /**
     * Initialize the underlying service.
     */
    public function boot()
    {
        $this->service = new Router();
        $this->initialized = true;
    }

    /**
     * Get the underlying service.
     *
     * @return ?Router
     */
    public function get() : ?Router
    {
        return $this->service;
    }

    // TODO Implemement these magic methods properly.
    public function __invoke()
    {
        return $this->get();
    }

    public function __call($name, $method)
    {
        return $this->get();
    }
}

