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
        $this->repo = $this->getDm()->getRepository('DCMS\Bundle\CoreBundle\Document\Endpoint');
    }

    public function testGetEndpoints()
    {
        $eps = $this->repo->getEndpoints('/no/path');
        $this->assertCount(0, $eps);
        $eps = $this->repo->getEndpoints('/sites/dantleech.com');
        $this->assertCount(2, $eps);
    }

    public function testGetEndpointsForSelect()
    {
        $epsForSelect = $this->repo->getEndpointsForSelect('/sites/dantleech.com');
        $this->assertCount(2, $epsForSelect);

        $expected = array(
            '/sites/dantleech.com/endpoints/home' => '/endpoints/home',
            '/sites/dantleech.com/endpoints/home/contact' => '/endpoints/home/contact',
        );

        $this->assertEquals($expected, $epsForSelect);
    }
}
