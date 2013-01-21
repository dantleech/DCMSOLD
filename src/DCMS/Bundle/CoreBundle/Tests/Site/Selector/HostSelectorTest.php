<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\HostSelector;

class HostSelectorTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->repo = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Repository\SiteRepository')
          ->disableOriginalConstructor()
          ->getMock();
        $this->requestContext = $this->getMockBuilder('Symfony\Component\Routing\RequestContext')
            ->disableOriginalConstructor()
            ->getMock();
        $this->hostSelect = new HostSelector($this->repo, $this->requestContext);
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testSelect_notFound()
    {
        $this->requestContext->expects($this->once())
            ->method('getHost')
            ->will($this->returnValue('example.com'));
        $this->repo->expects($this->once())
            ->method('getByHost')
            ->with('example.com')
            ->will($this->returnValue(null));
        $this->hostSelect->select();
    }

    public function testSelect_ok()
    {
        $this->requestContext->expects($this->once())
            ->method('getHost')
            ->will($this->returnValue('example.com'));
        $this->repo->expects($this->once())
            ->method('getByHost')
            ->with('example.com')
            ->will($this->returnValue('ok'));
        $res = $this->hostSelect->select();
        $this->assertEquals('ok', $res);
    }
}
