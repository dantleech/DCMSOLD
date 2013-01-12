<?php

namespace DCMS\Bundle\BlogBundle\Tests\Repository;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class PostRepositoryTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
            'DCMS\Bundle\BlogBundle\DataFixtures\PHPCR\LoadBlogData',
        ));

        $this->client = $this->createClient();
        $this->rep = $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
        $this->blog = $this->getDm()->find(null, '/sites/dantleech.com/endpoints/dans-blog');
        $this->blog2 = $this->getDm()->find(null, '/sites/dantleech.com/endpoints/bicycle-tour-2013');
    }

    public function testSearch()
    {
        $posts = $this->rep->search(array(
        ));
        $this->assertCount(40, $posts);

        $posts = $this->rep->search(array(
            'blog_uuid' => $this->blog->getUuid()
        ));
        $this->assertCount(20, $posts);

        $posts = $this->rep->search(array(
            'tag' => 'test',
        ));
        $this->assertCount(1, $posts);

        $posts = $this->rep->search(array(
            'tag' => 'test',
            'blog_uuid' => $this->blog->getUuid()
        ));
        $this->assertCount(1, $posts);

        $posts = $this->rep->search(array(
            'tag' => 'test',
            'blog_uuid' => $this->blog2->getUuid()
        ));
        $this->assertCount(0, $posts);
    }
}
