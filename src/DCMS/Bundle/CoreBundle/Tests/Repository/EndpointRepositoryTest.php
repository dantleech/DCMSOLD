<?php

namespace DCMS\Bundle\CoreBundle\Tests\Repository;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointRepositoryTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ));
        $this->repository = $this->getContainer()->get('dcms_core.repository.endpoint');
        $this->mm = $this->getContainer()->get('dcms_core.module_manager');
        $mm = $this->mm->createModule('test');
        $mm->createEndpointDefinition('DCMS\Bundle\CoreBundle\Document\Endpoint')
            ->setRoutingResource('@DCMSCoreBundle/Tests/Fixtures/config/endpoint_routing.yml');
    } 

    public function testFindManyByUrl()
    {
        $url = '/home/contact';
        $coll = $this->repository->findManyByUrl($url);
        $route = $coll->get('index');
        $this->assertEquals('/home/contact/', $route->getPattern());
        $route = $coll->get('foobar');
        $this->assertEquals('/home/contact/foo/{bar}', $route->getPattern());
        $route = $coll->get('barfoo');
        $this->assertEquals('/home/contact/foo/{bar}/tag/boo', $route->getPattern());
    }

    public function testFindManyByUrl_noMatch()
    {
        $url = 'asd';
        $coll = $this->repository->findManyByUrl($url);
        $this->assertNull($coll);
    }
}
