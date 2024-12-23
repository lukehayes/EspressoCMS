<?php
namespace Espresso\Service;

/**
 * Base class that all services should inherit.
 */
abstract class Service
{
    /**
     * @var bool Has the service been initialized?
     */
    protected bool $initialized = false;

    /**
     * Initialize the underlying service.
     */
    abstract public function boot();

    /**
     * Get the underlying service.
     *
     * @return mixed.
     */
    abstract public function get() : mixed;

    /**
     * Getter to check if the service has been initialized.
     *
     * @return bool.
     */
    public function hasInitialized() : bool
    {
        return $this->initialized;
    }
}
