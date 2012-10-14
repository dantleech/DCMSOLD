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
        $manager->flush();
    }
}
