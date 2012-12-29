<?php

namespace DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\CoreBundle\Document\Site;
use DCMS\Bundle\CoreBundle\Document\Folder;

class LoadSiteData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/');

        $f = new Folder;
        $f->setParent($rt);
        $f->setNodeName('sites');
        $manager->persist($f);

        $s = new Site;
        $s->setParent($f);
        $s->setName('dantleech');
        $manager->persist($s);

        $endpoints = new Folder;
        $endpoints->setParent($s);
        $endpoints->setNodeName('endpoints');
        $manager->persist($endpoints);

        $templates = new Folder;
        $templates->setParent($s);
        $templates->setNodeName('templates');
        $manager->persist($templates);

        $manager->flush();
    }
}


