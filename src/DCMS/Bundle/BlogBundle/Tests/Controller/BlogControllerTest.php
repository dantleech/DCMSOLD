<?php

namespace DCMS\Bundle\BlogBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\ThemeBundle\DataFixtures\PHPCR\LoadTemplateData',
            'DCMS\Bundle\BlogBundle\DataFixtures\PHPCR\LoadBlogData'
        ));
        $this->client = $this->createClient();
        $this->postRep = $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
        $this->post1 = $this->postRep->findOneBy(array());
        $this->blog1 = $this->getDm()->find(null, '/sites/dantleech.com/endpoints/dans-blog');
    }

    public function testRender()
    {
        $this->client->request(
            'get', 
            '/dans-blog/'
        );

        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }
}

