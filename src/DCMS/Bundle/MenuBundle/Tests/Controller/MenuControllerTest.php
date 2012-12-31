<?php

namespace DCMS\Bundle\MenuBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\MenuBundle\DataFixtures\PHPCR\LoadMenuData'
        ));
        $this->client = $this->createClient();
        $this->menuRep = $this->getDm()->getRepository('DCMS\Bundle\MenuBundle\Document\Menu');
        $this->menu1 = $this->menuRep->find('/sites/dantleech.com/menus/Main Menu');
    }

    public function testIndex()
    {
        $this->client->request('get', $this->getUrl('dcms_menu_menu_index', array()));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }

    public function testEdit()
    {
        $this->client->request('get', $this->getUrl('dcms_menu_menu_edit', array(
            'menu_uuid' => $this->menu1->getUuid()
        )));
        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }
}

