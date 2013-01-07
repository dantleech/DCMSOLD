<?php

namespace DCMS\Bundle\CoreBundle\Tests\Helper;
use DCMS\Bundle\CoreBundle\Helper\EndpointControllerFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EndpointControllerFactoryTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->cnp = $this->getMockBuilder('Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser')
          ->disableOriginalConstructor()
          ->getMock();
        $this->ep = new \stdClass;
        $this->form = new \stdClass;
        $this->epDef = new \stdClass;
        
        $this->container = new ContainerBuilder;
        $this->factory = new EndpointControllerFactory($this->container, $this->cnp);
    }

    public function testGetResponse()
    {
        $this->cnp->expects($this->once())
            ->method('parse')
            ->will($this->returnValue('\DCMS\Bundle\CoreBundle\Tests\Helper\EPTestController::foo'));


        // note: would normally return a response object ..
        $controller = $this->factory->getResponse('This:doesnt:matter', $this->ep, $this->form);
        $this->assertSame($this->container, $controller->container);
        $this->assertSame($this->ep, $controller->endpoint);
        $this->assertSame($this->form, $controller->form);
    }
}

class EPTestController
{
    public $endpoint;
    public $form;
    public $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function foo($endpoint, $form)
    {
        $this->endpoint = $endpoint;
        $this->form = $form;

        return $this;
    }
}

