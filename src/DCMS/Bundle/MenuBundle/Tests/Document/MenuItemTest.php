<?php

namespace DCMS\Bundle\MenuBundle\Tests\Document;
use DCMS\Bundle\MenuBundle\Document\MenuItem;


class MenuItemTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        
    }

    public function testToArray()
    {
        $mi = MenuItem::create('root', 'Root')
            ->addChild(MenuItem::create('child1', 'Child 1'))
            ->addChild(MenuItem::create('child1', 'Child 1')->addChild(MenuItem::create('child1-1', 'Child 1 1')));
        $arr = $mi->toArray();
        $this->assertEquals(array(), $arr);
    }
}

