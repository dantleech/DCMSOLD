<?php

namespace DCMS\Bundle\ThemeBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class TemplateControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\ThemeBundle\DataFixtures\PHPCR\LoadTemplateData',
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        ));

        $this->client = $this->createClient();
        $this->site = $this->getDm()->find(null, '/sites/dantleech.com');
        // $this->rep = $this->getDm()->getRepository('DCMS\Bundle\MenuBundle\Document\Menu');
        // $this->menu1 = $this->menuRep->find('/sites/dantleech.com/menus/Main Menu');
    }

    public function testIndex()
    {
        $this->client->request(
            'get', 
            $this->getUrl('dcms_theme_template_index')
        );

        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }

    public function testIndex_nonExistingDefaultTemplate()
    {
        $this->site->setPreference('dcms_theme.default_layout_uuid', '7d5afe5e-2454-48c9-b2ef-de7e09332f3c');
        $this->getDm()->persist($this->site);
        $this->getDm()->flush();

        $this->client->request(
            'get', 
            $this->getUrl('dcms_theme_template_index')
        );

        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }
}
