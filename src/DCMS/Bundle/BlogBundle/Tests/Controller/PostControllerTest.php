<?php

namespace DCMS\Bundle\BlogBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\BlogBundle\DataFixtures\PHPCR\LoadBlogData'
        ));
        $this->client = $this->createClient();
        $this->postRep = $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
        $this->post1 = $this->postRep->findOneBy(array());
        $this->blog1 = $this->getDm()->find(null, '/sites/dantleech.com/endpoints/dans-blog');
    }

    public function testIndex()
    {
        $this->client->request(
            'get', 
            $this->getUrl('dcms_blog_post_index')
        );

        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }

    public function testEdit_get()
    {
        $this->client->request(
            'get', 
            $this->getUrl('dcms_blog_post_edit', array(
                'post_uuid' => $this->post1->getUuid(),
            ))
        );

        $resp = $this->client->getResponse();
        $this->assertEquals(200, $resp->getStatusCode());
    }

    public function testEdit_post()
    {
        $this->client->request(
            'post', 
            $this->getUrl('dcms_blog_post_edit', array(
                'post_uuid' => $this->post1->getUuid(),
            )), array(
                'post' => array(
                    'title' => 'Hello',
                    'blog' => '/sites/dantleech.com/endpoints/dans-blog',
                )
            )
        );

        $resp = $this->client->getResponse();

        // redirect is good..
        $this->assertEquals(302, $resp->getStatusCode());
    }
}
