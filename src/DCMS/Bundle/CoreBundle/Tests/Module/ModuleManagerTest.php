<?php

namespace DCMS\Bundle\CoreBundle\Tests\Module;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mm = new ModuleManager;
    }

    public function testModuleManagerSetup()
    {
        $m = $this->mm->createModule('test1');
        $m->createEndpointDefinition('ep1', 'FQN/Foo/Bar')
            ->setIcon('foo/bar.png');
        $m->createEndpointDefinition('ep2', 'FQN/Foo/Bar')
            ->setIcon('foo/bar.png');

        $m = $this->mm->createModule('test2');
        $m->createEndpointDefinition('FQN/Foo/Bar1')
            ->setIcon('foo/bar.png');
        $m->createEndpointDefinition('FQN/Foo/Bar2')
            ->setIcon('foo/bar.png');

        $this->assertEquals(array('test1', 'test2'), $this->mm->getRegisteredModuleNames());
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Module\Exception\ModuleAlreadyDefined
     */
    public function testMMDuplicateModuleDefinition()
    {
        $m = $this->mm->createModule('test1');
        $m = $this->mm->createModule('test1');
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Module\Exception\EndpointAlreadyDefined
     */
    public function testMMDuplicateEndpointDefinition()
    {
        $m = $this->mm->createModule('test1');
        $m->createEndpointDefinition('test');
        $m->createEndpointDefinition('test');
    }
}
