<?php

namespace Fudge\SilexComponents\DependencyInjection;

use Silex\Application;

/**
 * @group serviceProvider
 */
class DependencyInjectionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group exists
     */
    public function testExistence()
    {
        $className = __NAMESPACE__.'\\DependencyInjectionServiceProvider';
        $this->assertTrue(class_exists($className));
        $this->assertContains('Silex\\ServiceProviderInterface', class_implements($className));
    }

    /**
     * @covers Fudge\SilexComponents\DependencyInjection\DependencyInjectionServiceProvider::register
     * @covers Fudge\SilexComponents\DependencyInjection\DependencyInjectionServiceProvider::boot
     */
    public function testSettingOfDependencyInjectionControllerResolver()
    {
        $app = new Application;
        $app->register(new DependencyInjectionServiceProvider);
        $this->assertInstanceOf(__NAMESPACE__."\\ControllerResolver", $app['resolver']);
    }
}
