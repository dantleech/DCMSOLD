<?php

namespace DCMS\Bundle\CoreBundle\Tests\Twig\Extension;

use DCMS\Bundle\CoreBundle\Twig\Extension\DCMSCoreExtension;

class DCMSCoreExtensionTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $nh = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Helper\NotificationHelper')
            ->disableOriginalConstructor()
            ->getMock();
        $epContext = $this->getMock('DCMS\Bundle\CoreBundle\Helper\EpContext');
        $this->sc = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Site\SiteContext')
          ->disableOriginalConstructor()
          ->getMock();
        
        $this->extension = new DCMSCoreExtension($nh, $epContext, $this->sc);
    }

    public function testEpPath()
    {
        $ep = $this->getMock('DCMS\Bundle\CoreBundle\Document\Endpoint');
        $this->sc->expects($this->once())
            ->method('getEndpointPath')
            ->will($this->returnValue('/mytestsite/endpoints'));
        $ep->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('/mytestsite/endpoints/foobar/barfoo'));
        $path = $this->extension->epPath($ep);
        $this->assertEquals('/foobar/barfoo', $path);

    }
}

