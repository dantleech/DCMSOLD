<?php

namespace DCMS\Bundle\AdminBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint;

class LoadEndpointData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/');

        $e = new MarkdownEndpoint;
        $e->setParent($rt);
        $e->setNodeName('home');
        $e->setPath('/');
        $e->setContent(<<<FOO
This is a test
==============

This is the most basic endpoint I can be bothered to make.
FOO
    );
        $manager->persist($e);

        $e = new MarkdownEndpoint;
        $e->setParent($rt);
        $e->setNodeName('cv');
        $e->setPath('/cv');
        $e->setContent(<<<FOO
Curriculum Vitae
================

This is my extensive CV.

What I do
---------

Not much

What I want to do
-----------------

Not much
FOO
    );
        $manager->persist($e);

        $about = new MarkdownEndpoint;
        $about->setParent($rt);
        $about->setNodeName('about');
        $about->setPath('/about');
        $about->setContent(<<<FOO
About this site
FOO
    );
        $manager->persist($about);

        $e = new MarkdownEndpoint;
        $e->setParent($about);
        $e->setNodeName('me');
        $e->setPath('/me');
        $e->setContent(<<<FOO
About me
FOO
    );
        $manager->persist($e);

        $e = new MarkdownEndpoint;
        $e->setParent($about);
        $e->setNodeName('them');
        $e->setPath('/them');
        $e->setContent(<<<FOO
About them 
FOO
    );
        $manager->persist($e);

        $manager->flush();
    }
}
