<?php

namespace DCMS\Bundle\CoreBundle\Tests\Routing;

use DCMS\Bundle\CoreBundle\Routing\EndpointMapper;
use DCMS\Bundle\CoreBundle\Document\Endpoint;

// @todo: Delete this class - not used now. .. (i don't think so anyway)
class EndpointMapperTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->mm = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Module\ModuleManager')
          ->disableOriginalConstructor()
          ->getMock();
        $this->epContext = $this->getMock('DCMS\Bundle\CoreBundle\Helper\EpContext');
        $this->request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mapper = new EndpointMapper($this->mm, $this->epContext);
        $this->endpoint = $this->getMock('DCMS\Bundle\CoreBundle\Document\Endpoint');;
    }

    public function testGetController()
    {
        $defaults = array(
            'endpoint' => $this->endpoint
        );
        $res = $this->mapper->enhance($defaults, $this->request);
    }
}

