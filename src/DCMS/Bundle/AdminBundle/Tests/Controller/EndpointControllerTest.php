<?php

namespace DCMS\Bundle\AdminBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function testIndex()
    {
        $this->client->request('get', $this->getUrl('dcms_admin_endpoint_index'));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }
}
