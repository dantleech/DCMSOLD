<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site;
use DCMS\Bundle\CoreBundle\Site\SiteManager;

class SiteManagerTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->sr = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Repository\SiteRepository')
          ->disableOriginalConstructor()
          ->getMock();
        $this->sm = new SiteManager($this->sr);
        $this->site = $this->getMock('DCMS\Bundle\CoreBundle\Document\Site');
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testGetSite_notFound()
    {
        $this->sm->getSite();
    }

    public function testGetSite_found()
    {
        $this->sr->expects($this->once())
          ->method('find')
          ->will($this->returnValue($this->site));
        $this->sm->getSite();
    }
}

