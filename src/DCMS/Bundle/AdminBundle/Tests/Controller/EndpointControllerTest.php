<?php

namespace DCMS\Bundle\AdminBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array(
            'DCMS\Bundle\AdminBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ), null, 'doctrine_phpcr');

        $this->repo = $this->getDm()->getRepository('DCMS\Bundle\CoreBundle\Document\Endpoint');
        $this->ep1 = $this->repo->find('/ep1');
        $this->ep2 = $this->repo->find('/ep2');
        $this->ep3 = $this->repo->find('/ep3');
    }

    public function testUpdateTreeChangeParent()
    {
        $client = $this->makeClient(true);
        $client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep1->getUuid(),
                'parent' => $this->ep2->getUuid(),
            ),
        ));
        $resp = $client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $ep2 = $this->repo->find('/ep2');
        $children = $ep2->getChildren();
        $this->assertEquals(1, count($children));
        $this->assertEquals('ep1', $children->first()->getNodeName());
    }

    public function testUpdateTreeChangeParentNull()
    {
        $client = $this->makeClient(true);
        $client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep1->getUuid(),
                'parent' => '',
            ),
        ));
        $resp = $client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $ep1 = $this->repo->find($this->ep1->getUuid());
        $parent = $ep1->getParent();
        $this->assertEquals('/', $parent->getId());
    }

    public function testUpdateTreeReorderAfter()
    {
        $client = $this->makeClient(true);
        $client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep3->getUuid(),
                'next' => $this->ep1->getUuid(),
            ),
        ));
        $resp = $client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $root = $this->repo->find(null, '/');
        $children = $root->getChildren();
        $this->assertEquals('ep3', $children->first()->getNodeName());
    }

    public function testUpdateTreeReorderPrev()
    {
        $client = $this->makeClient(true);
        $client->request('post', $this->getUrl('dcms_admin_endpoint_updatetree'), array(
            'command' => array(
                'source' => $this->ep3->getUuid(),
                'prev' => $this->ep1->getUuid(),
            ),
        ));
        $resp = $client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());

        $this->getDm()->clear();
        $root = $this->repo->find(null, '/');
        $children = $root->getChildren()->toArray();
        $keys = array_keys($children);
        $this->assertEquals('ep3', $keys[1]);
    }

    public function testCreate_get()
    {
        $client = $this->makeClient();
        $client->request('get', $this->getUrl('dcms_admin_endpoint_create'));
        $resp = $client->getResponse();
        $this->assertResponseOK($resp);
    }

    public function testCreate_post()
    {
        $client = $this->makeClient();
        $client->request('post', $this->getUrl('dcms_admin_endpoint_create'), array(
            'endpoint' => array(
                'type' => 'DCMS\Bundle\CoreBundle\Document\Endpoint',
                'path' => '/hello',
            ),
        ));
        $resp = $client->getResponse();
        $this->assertEquals('300', $resp->getStatusCode());
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
