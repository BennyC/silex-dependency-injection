<?php

namespace Fudge\SilexComponents\DependencyInjection;

use Silex\Application;
use Fudge\SilexComponents\DependencyInjection\Fixtures\Foo;
use Fudge\SilexComponents\DependencyInjection\Fixtures\Bar;

/**
 * @group controllerResolver
 */
class ControllerResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group exists
     */
    public function testExistence()
    {
        $className = __NAMESPACE__."\\ControllerResolver";
        $this->assertTrue(class_exists($className));
    }

    /**
     * @group controllerCreation
     */
    public function testEnsureInterfacesReturnCorrectly()
    {
        $app = new Application;
        $app['Fudge\SilexComponents\DependencyInjection\Fixtures\Foo'] = function () {
            return new Bar();
        };

        $controllerResolver = new ControllerResolver($app, $app['logger']);
        $controller = $controllerResolver->buildController(__NAMESPACE__.'\\Fixtures\\ControllerExample');

        $this->assertTrue($controller->getFoo() instanceof Bar);
    }
}
