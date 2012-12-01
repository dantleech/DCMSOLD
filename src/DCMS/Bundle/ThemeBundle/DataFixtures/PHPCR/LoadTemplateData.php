<?php

namespace DCMS\Bundle\ThemeBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DCMS\Bundle\ThemeBundle\Document\Template;

class LoadMenuEndpointData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/sites/dantleech/templates');

        $e = new Template;
        $e->setParent($rt);
        $e->setTitle('Bar Template');
        $e->setResource('DCMSThemeBundle:Foo:bar.html.twig');
        $e->setSource('<!doctype html><html><body>Hello</body></html><');
        $e->setType('layout');
        $manager->persist($e);

        $manager->flush();
    }
}

