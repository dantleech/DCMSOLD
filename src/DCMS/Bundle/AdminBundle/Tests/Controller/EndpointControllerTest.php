<?php

namespace DCMS\Bundle\AdminBundle\Tests\Controller;
use DCMS\Bundle\Bundle\CoreBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array(
            'DCMS\Bundle\AdminBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ));
    }

    public function testUpdateTree()
    {
        $client = $this->makeClient(true);
    }
}
