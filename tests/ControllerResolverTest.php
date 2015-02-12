<?php

namespace Fudge\SilexComponents\DependencyInjection;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Fudge\SilexComponents\DependencyInjection\Fixtures\Foo;
use Fudge\SilexComponents\DependencyInjection\Fixtures\Bar;
use Fudge\SilexComponents\DependencyInjection\Fixtures\StandardController;
use Fudge\SilexComponents\DependencyInjection\Fixtures\NoDependencyController;

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
        $request = $this->createRequestForController(StandardController::class.'::getFoo');

        $app['Fudge\SilexComponents\DependencyInjection\Fixtures\Foo'] = function () {
            return new Bar();
        };

        $controllerResolver = new ControllerResolver($app, $app['logger']);
        list($controller, $methodName) = $controllerResolver->getController($request);

        $this->assertTrue($controller->getFoo() instanceof Bar);
        $this->assertEquals('getFoo', $methodName);
    }

    /**
     * @group controllerCreation
     */
    public function testEnsureNoDependencies()
    {
        $app = new Application;
        $request = $this->createRequestForController(NoDependencyController::class.'::getFoo');

        $controllerResolver = new ControllerResolver($app, $app['logger']);
        list($controller, $methodName) = $controllerResolver->getController($request);

        $this->assertInstanceOf(__NAMESPACE__.'\\Fixtures\NoDependencyController', $controller);
        $this->assertNull($controller->getFoo());
    }

    /**
     * Create a Symfony Request with the "_controller" attribute set to the
     * value of $controllerString
     * @coversNothing
     */
    public function createRequestForController($controllerString)
    {
        return new Request([], [], ['_controller' => $controllerString]);
    }
}
