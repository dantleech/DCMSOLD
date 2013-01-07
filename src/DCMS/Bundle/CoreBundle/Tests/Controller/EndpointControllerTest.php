<?php

namespace DCMS\Bundle\CoreBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\ThemeBundle\DataFixtures\PHPCR\LoadTemplateData'
        ));
        $this->client = $this->createClient();
    }

    public function testDefaultAction()
    {
        $this->client->request('get', '/');
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }
}
