<?php
namespace Espresso\Service;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * A specific kind of Exception for the Psr\Container.
 */
class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

