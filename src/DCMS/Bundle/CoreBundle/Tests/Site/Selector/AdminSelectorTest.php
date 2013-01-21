<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\AdminSelector;

class AdminSelectorTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->repo = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Repository\SiteRepository')
          ->disableOriginalConstructor()
          ->getMock();
        $this->adminSelect = new AdminSelector($this->repo);
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testSelect_noName()
    {
        $this->adminSelect->select();
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testSelect_notFound()
    {
        $this->adminSelect->setName('test.com');
        $this->repo->expects($this->once())
            ->method('getByHost')
            ->with('test.com')
            ->will($this->returnValue(null));
        $this->adminSelect->select();
    }

    public function testSelect_ok()
    {
        $this->adminSelect->setName('test.com');
        $this->repo->expects($this->once())
            ->method('getByHost')
            ->with('test.com')
            ->will($this->returnValue('ok'));
        $res = $this->adminSelect->select();
        $this->assertEquals('ok', $res);
    }
}

