<?php

namespace DCMS\Bundle\CoreBundle\Tests\Mapper;

use DCMS\Bundle\CoreBundle\Mapper\EndpointMapper;

class EndpointMapperTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->mm = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Module\ModuleManager')
          ->disableOriginalConstructor()
          ->getMock();
        $this->epContext = $this->getMock('DCMS\Bundle\CoreBundle\Helper\EpContext');
        $this->route = $this->getMockBuilder('Symfony\Component\Routing\Route')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mapper = new EndpointMapper($this->mm, $this->epContext);
    }

    public function testGetController()
    {
        $this->route->expects($this->once())
            ->method('getDefault')
            ->with('endpoint');

        $defaults = array();
        $res = $this->mapper->getController($this->route, $defaults);
    }
}

