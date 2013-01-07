<?php

namespace DCMS\Bundle\ThemeBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DCMS\Bundle\ThemeBundle\Document\Template;

class LoadTemplateData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/sites/dantleech.com/templates');

        $l = new Template;
        $l->setParent($rt);
        $l->setTitle('Bar Template');
        $l->setResource('homepage.html.twig');
        $l->setSource(file_get_contents(__DIR__.'/data/layout.html.twig'));
        $l->setType('layout');
        $manager->persist($l);

        $e = new Template;
        $e->setParent($rt);
        $e->setTitle('Stylesheet');
        $e->setResource('homepage.css.twig');
        $e->setSource(file_get_contents(__DIR__.'/data/homepage.css'));
        $e->setType('stylesheet');
        $manager->persist($e);

        $manager->flush();

        $site = $manager->find(null, '/sites/dantleech.com');
        $site->setPreference('dcms_theme.default_layout_uuid', $l->getUuid());
        $manager->persist($site);
        $manager->flush();
    }
}
