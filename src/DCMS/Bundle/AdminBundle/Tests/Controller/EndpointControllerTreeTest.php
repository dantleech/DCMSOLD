<?php

namespace DCMS\Bundle\AdminBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class EndpointControllerTreeTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\AdminBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ));

        $this->repo = $this->getDm()->getRepository('DCMS\Bundle\CoreBundle\Document\Endpoint');
        $this->ep1 = $this->repo->find('/ep1');
        $this->ep2 = $this->repo->find('/ep2');
        $this->ep3 = $this->repo->find('/ep3');
        $this->client = $this->createClient();
    }

    public function testUpdateTreeChangeParent()
    {
        $this->client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep1->getUuid(),
                'parent' => $this->ep2->getUuid(),
            ),
        ));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $ep2 = $this->repo->find('/ep2');
        $children = $ep2->getChildren();
        $this->assertEquals(1, count($children));
        $this->assertEquals('ep1', current($children)->getTitle());
    }

    public function testUpdateTreeChangeParentNull()
    {
        $this->client = $this->createClient();
        $this->client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep1->getUuid(),
                'parent' => '',
            ),
        ));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $ep1 = $this->repo->find($this->ep1->getUuid());
        $parent = $ep1->getParent();
        $this->assertEquals('/', $parent->getId());
    }

    public function testUpdateTreeReorderAfter()
    {
        $this->client = $this->createClient();
        $this->client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep3->getUuid(),
                'next' => $this->ep1->getUuid(),
            ),
        ));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $root = $this->repo->find(null, '/');
        $children = $root->getChildren();
        $this->assertEquals('ep3', current($children)->getTitle());
    }

    public function testUpdateTreeReorderPrev()
    {
        $this->client = $this->createClient();
        $this->client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep3->getUuid(),
                'prev' => $this->ep1->getUuid(),
            ),
        ));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $root = $this->repo->find(null, '/');
        $children = (array) $root->getChildren();
        $keys = array_keys($children);
        $this->assertEquals('ep3', $keys[1]);
    }

    public function testCreate_post()
    {
        $this->client = $this->createClient();
        $this->client->request('post', $this->getUrl('dcms_admin_endpoint_create'), array(
            'endpoint' => array(
                'type' => 'DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint',
                'title' => 'Hello',
            ),
        ));
        $resp = $this->client->getResponse();
        $this->assertEquals('200', $resp->getStatusCode());
    }

    protected function assertResponseOK(Response $response)
    {
        $status = $response->getStatusCode();
        if ($status != 200) {
            die(strip_tags($response->getContent()));
        }
        $this->assertEquals(200, $status);
    }
}
