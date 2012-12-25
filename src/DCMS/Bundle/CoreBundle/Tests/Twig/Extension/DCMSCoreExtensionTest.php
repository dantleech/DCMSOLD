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
        $this->extension = new DCMSCoreExtension($nh, $epContext);
    }

    public function testEpPath()
    {
        $ep = $this->getMock('DCMS\Bundle\CoreBundle\Document\Endpoint');
        $ep->expects($this->once())
            ->method('getFullPath');
        $this->extension->epPath($ep);
    }
}

