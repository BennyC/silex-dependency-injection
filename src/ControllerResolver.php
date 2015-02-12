<?php

namespace Fudge\SilexComponents\DependencyInjection;

/**
 * @package fudge/silex-container-aware
 * @version 0.2.0
 */
class ControllerResolver extends \Silex\ControllerResolver
{
    /**
     * Will go through the controller to find all of the dependencies, will
     * then find them within the container.
     * @param string
     * @return mixed
     */
    protected function instantiateController($controllerName)
    {
        $reflection = new \ReflectionClass($controllerName);
        $construct  = $reflection->getConstructor();

        if (! $construct) {
            return $reflection->newInstance();
        }

        $parameters = $construct->getParameters();
        $list = [];

        foreach ($parameters as $p) {
            array_push($list, $this->app[$p->getClass()->name]);
        }

        return $reflection->newInstanceArgs($list);
    }
}
