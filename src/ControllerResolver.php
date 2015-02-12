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
        $list = $this->createArgumentList($parameters);

        return $reflection->newInstanceArgs($list);
    }

    /**
     * Create a list of dependencies ready to inject into the new
     * instance.
     * @param array
     * @return array
     */
    protected function createArgumentList(array $parameters)
    {
        $app = $this->app;

        return array_map(function ($p) use ($app) {
            $className = $p->getClass()->name;

            if (! isset($app[$className])) {
                throw new \RuntimeException(
                    sprintf('Missing service definition within Application Container: %s', $className)
                );
            }

            return $app[$className];
        }, $parameters);
    }
}
