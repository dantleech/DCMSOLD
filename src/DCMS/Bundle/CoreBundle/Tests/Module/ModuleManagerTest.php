<?php

namespace DCMS\Bundle\CoreBundle\Tests\Module;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mm = new ModuleManager;

        $this->m1 = $this->mm->createModule('test1');
        $this->m1->createEndpointDefinition('FQN/Foo/Bar1')
            ->setIcon('foo/bar.png')
            ->setTitle('Foobar1');
        $this->m1->createEndpointDefinition('FQN/Foo/Bar2')
            ->setIcon('foo/bar.png')
            ->setTitle('Foobar2');

        $this->m2 = $this->mm->createModule('test2');
        $this->m2->createEndpointDefinition('FQN/Foo/Bar1')
            ->setIcon('foo/bar.png')
            ->setTitle('Boofar1');
        $this->m2->createEndpointDefinition('FQN/Foo/Bar2')
            ->setTitle('Boofar2')
            ->setIcon('foo/bar.png');

    }

    public function testModuleManagerSetup()
    {
        $this->assertEquals(array('test1', 'test2'), $this->mm->getRegisteredModuleNames());
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Module\Exception\ModuleAlreadyDefined
     */
    public function testMMDuplicateModuleDefinition()
    {
        $m = $this->mm->createModule('test9');
        $m = $this->mm->createModule('test9');
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Module\Exception\EndpointAlreadyDefined
     */
    public function testMMDuplicateEndpointDefinition()
    {
        $m = $this->mm->createModule('test9');
        $m->createEndpointDefinition('test');
        $m->createEndpointDefinition('test');
    }

    public function testGetEndpointsForSelect()
    {
        $forSelect = $this->mm->getEndpointsForSelect();
        $this->assertEquals(array(
            'test1' => array(
                'FQN/Foo/Bar1' => 'Foobar1',
                'FQN/Foo/Bar2' => 'Foobar2',
            ),
            'test2' => array(
                'FQN/Foo/Bar1' => 'Boofar1',
                'FQN/Foo/Bar2' => 'Boofar2',
            )
        ), $forSelect);
    }
}
