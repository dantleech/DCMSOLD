<?php

namespace DCMS\Bundle\CoreBundle\DataFixtures\PHPCR;

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
        $s->setName('dantleech.com');
        $manager->persist($s);

        $f = new Folder;
        $f->setParent($s);
        $f->setNodeName('endpoints');
        $manager->persist($f);

        $f = new Folder;
        $f->setParent($s);
        $f->setNodeName('templates');
        $manager->persist($f);

        $manager->flush();
    }
}

