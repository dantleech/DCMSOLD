<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site;
use DCMS\Bundle\CoreBundle\Site\SiteContext;

class SiteContextTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->sr = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Repository\SiteRepository')
          ->disableOriginalConstructor()
          ->getMock();
        $this->sc = new SiteContext($this->sr);
        $this->site = $this->getMock('DCMS\Bundle\CoreBundle\Document\Site');
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testGetSite_notFound()
    {
        $this->sc->getSite();
    }

    public function testGetSite_found()
    {
        $this->sr->expects($this->once())
          ->method('find')
          ->will($this->returnValue($this->site));
        $this->sc->getSite();
    }
}

