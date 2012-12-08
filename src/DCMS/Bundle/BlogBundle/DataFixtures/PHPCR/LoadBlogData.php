<?php

namespace DCMS\Bundle\MarkdownBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\CoreBundle\Document\Folder;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Document\BlogEndpoint;

class LoadBlogData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $epRoot = $manager->find(null, '/sites/dantleech/endpoints');
        $ep = new BlogEndpoint;
        $ep->setParent($epRoot);
        $ep->setNodeName('Dans Blog');
        $ep->setPath('/blog');
        $manager->persist($ep);
        $manager->flush();

        $rt = $manager->find(null, '/sites/dantleech');
        $folder = new Folder;
        $folder->setNodeName('blogs');
        $folder->setParent($rt);
        $manager->persist($folder);

        $p = new Post;
        $p->setTitle('Foo bar post');
        $p->setDate(new \DateTime());
        $p->setBody('This is a test post');
        $p->setParent($folder);
        $p->setBlog($ep);
        $manager->persist($p);

        $manager->flush();
    }
}

