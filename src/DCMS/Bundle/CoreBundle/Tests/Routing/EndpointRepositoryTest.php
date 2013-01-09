<?php

namespace DCMS\Bundle\CoreBundle\Tests\Routing;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointRepositoryTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ));
        $this->repository = $this->getContainer()->get('dcms_core.repository.endpoint');
        $this->req = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mm = $this->getContainer()->get('dcms_core.module_manager');
        $this->mm->createModule('test')
            ->createEndpointDefinition('DCMS\Bundle\CoreBundle\Document\TestEndpoint')
            ->setRoutingResource('@DCMSCoreBundle/Tests/Fixtures/config/endpoint_routing.yml');
    } 

    public function testGetRouteCollectionForRequest()
    {
        $url = '/home/contact/cv';
        $this->req->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue($url));
        $coll = $this->repository->getRouteCollectionForRequest($this->req);
        $route = $coll->get('index');
        $this->assertEquals('/home/contact/cv/', $route->getPattern());
        $route = $coll->get('foobar');
        $this->assertEquals('/home/contact/cv/foo/{bar}', $route->getPattern());
        $route = $coll->get('barfoo');
        $this->assertEquals('/home/contact/cv/foo/{bar}/tag/boo', $route->getPattern());
        $prefix = $coll->getPrefix();
        $this->assertEquals('/home/contact/cv', $prefix);
    }

    public function testGetRouteCollectionForRequest_noMatch()
    {
        $url = 'asd';
        $this->req->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue($url));
        $coll = $this->repository->getRouteCollectionForRequest($this->req);
        $this->assertNull($coll);
    }

    public function testGetRouteCollectionForRequest_home()
    {
        $url = '/';
        $this->req->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue($url));
        $coll = $this->repository->getRouteCollectionForRequest($this->req);
    }
}
