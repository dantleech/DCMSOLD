<?php

namespace DCMS\Bundle\BlogBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\MarkdownBundle\DataFixtures\PHPCR\LoadEndpointData'
        ));
        $this->client = $this->createClient();
        $this->epRep = $this->getDm()->getRepository('DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint');
        $this->ep1 = $this->epRep->find('/sites/dantleech/endpoints/cv');
    }

    public function testEdit()
    {
        $this->client->request('get', $this->getUrl('dcms_admin_endpoint_edit', array(
            'endpoint_uuid' => $this->ep1->getUuid()
        )));
        $resp = $this->client->getResponse();
        die($resp->getContent());
        $this->assertEquals(200, $resp->getStatusCode());
    }
}
