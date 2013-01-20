<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\DevSelector;

class DevSelectorTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->repo = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Repository\SiteRepository')
          ->disableOriginalConstructor()
          ->getMock();
        $this->devSelect = new DevSelector($this->repo);
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testSelect_noParam()
    {
        $this->devSelect->select();
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testSelect_notFound()
    {
        $_GET['_site'] = 'test.com';
        $this->repo->expects($this->once())
            ->method('findByHost')
            ->with('test.com')
            ->will($this->returnValue(null));
        $this->devSelect->select();
    }

    public function testSelect_ok()
    {
        $_GET['_site'] = 'test.com';
        $this->repo->expects($this->once())
            ->method('findByHost')
            ->with('test.com')
            ->will($this->returnValue('ok'));
        $res = $this->devSelect->select();
        $this->assertEquals('ok', $res);
    }
}
