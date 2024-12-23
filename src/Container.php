<?php
namespace Espresso;

use Espresso\Service\Service;
use Espresso\Service\ServiceNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * A very simple/basic service container.
 */
class Container implements ContainerInterface
{
    /**
     * @var array $sevices
     */
    private $services = [];

    /**
     * Value is set to true when all services have been initialsed.
     * @var bool $booted.
     */
    private bool $booted = false;

    public function __construct()
    {
        // Sets services inside container.
        $this->setDefaultServices();

        // Calls each services boot() method.
        $this->bootServices();
    }

    /**
     * Initialise all of the services defined inside the container.
     *
     * @return bool.
     */
    public function bootServices()
    {
        // TODO Implement a more concrete way of doing this.
        foreach($this->services as $name => $service)
        {
            $this->services[$name] = (new $service);
            ($this->services[$name])->boot();
        }

        $this->booted = true;
        return $this->booted;
    }

    /**
     * Returns true if container has intialized all of its services, false otherwise.
     *
     * @return bool.
     */
    public function hasBooted() : bool
    {
        return $this->booted;
    }

    /**
     * Get the amount of services defined inside the container.
     *
     * @return bool.
     */
    public function getServiceCount() : int
    {
        return count($this->services);
    }

    /**
     * Set all of the available services that should be available on boot.
     */
   private function setDefaultServices()
    {
        // TODO Add ability to add services from configuration file.
        $this->addService('Router',   \Espresso\Service\RouterService::class);
        //$this->addService('Twig',     \Espresso\Service\TwigService::class);
        //$this->addService('Database', \Espresso\Service\DatabaseService::class);
        //$this->addService('Doctrine', \Espresso\Service\DoctrineService::class);
        //$this->addService('App',      \Espresso\Service\AppService::class);
    }

    /**
     * Add a service to the container. If the service already exists,
     * then it will be overwritten.
     *
     * @param string $name        The name to give to the service for reference.
     *
     * @param string $service:    The complete service namespace.
     *
     * @return void.
     */
    public function addService(string $name, string $service) : void 
    {
        $this->services[ucfirst($name)] = $service;
    }

    /**
     * Get a new instance of a service from the container.
     *
     * @param string $name The name of the service to retrieve from the container.
     *
     * @throws ServiceNotFoundException.
     *
     * @return Service.
     */
    public function getInstance(string $name) : Service
    {
        $name = ucfirst($name);

        if(!$this->has($name))
            throw new ServiceNotFoundException("$name service could not be found.");

        return new ($this->get($name));
    }


    /**
     * Get a list of all the available services.
     *
     * @return array.
     */
    public function getServices() : array
    {
        return $this->services;
    }


    /**
     * Wrapper for Contianer::has() method.
     *
     * @throws ServiceNotFoundException.
     *
     * @return bool.
     */
    public function hasService(string $id) : bool
    {
        return $this->has($id);
    }


    /**
     * ---------------------------------------------------------------------
     * PSR CONTAINER
     * ---------------------------------------------------------------------
     *
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get(string $id) : mixed
    {
        // Container entries are always capitalized.
        // This guarantees that the ID will have
        // the correct capitaliztion.
        $upcaseID = ucfirst($id);

        if(!array_key_exists($upcaseID, $this->services))
        {
            throw new ServiceNotFoundException("Service: [$id] could not be found.");
        }else
        {
            $service = $this->services[$upcaseID];

            if(isset($service) && !empty($service))
                return $this->services[$upcaseID];
        }
    }


    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services) ? true : false;
    }
}
