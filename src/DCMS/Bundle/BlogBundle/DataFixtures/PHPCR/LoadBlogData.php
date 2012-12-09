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

        for ($i = 1; $i <= 20; $i++) {
            $p = new Post;
            $p->setTitle('Post '.$i);
            $p->setDate(new \DateTime());
            $p->setBody('This is a test post');
            $p->setParent($ep);
            $p->setBlog($ep);
            $p->setTags($this->getTags());
            $manager->persist($p);
        }

        $ep = new BlogEndpoint;
        $ep->setParent($epRoot);
        $ep->setNodeName('Bicycle tour 2013');
        $ep->setPath('/travel');
        $manager->persist($ep);
        $manager->flush();

        for ($i = 1; $i <= 20; $i++) {
            $p = new Post;
            $p->setTitle('Travel post '.$i);
            $p->setDate(new \DateTime());
            $p->setBody('This is a test post');
            $p->setParent($ep);
            $p->setBlog($ep);
            $p->setTags($this->getTags());
            $manager->persist($p);
        }
        $manager->flush();
    }

    protected function getTags()
    {
        $tags = array(
            'DropBox',
            'XMPP',
            'android',
            'apache',
            'archos',
            'audacious',
            'awesome',
            'bash',
            'bootstrap',
            'bristol',
            'diagramming',
            'doctrine',
            'doctrine2',
            'git',
            'gloucester',
            'graphs',
            'gt540',
            'jack',
            'javascript',
            'mail',
            'manchester',
            'mapdroyd',
            'markdown',
            'mongodb',
            'paris',
            'php',
            'profiling',
            'projectm',
            'running',
            'scripting',
            'sed',
            'software',
            'design',
            'ssh',
            'sup',
            'symfony',
            'symfony2',
            'thonon',
            'touring',
            'trainer',
            'travel',
            'twig',
            'ubnutu',
            'velo',
            'vim',
            'weymouth',
            'workflow',
            'xdebug',
            'xml',
            'ylly',
            'yprox',
        );

        $nbTags = rand(2,5);
        $sTags = array();
        for ($i = 0; $i < $nbTags; $i ++) {
            $sTags[] = $tags[rand(0, (count($tags) - 1))];
        }

        return $sTags;
    }
}

