<?php

namespace DCMS\Bundle\AdminBundle\Tests\Fixtures\ODM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DCMS\Bundle\CoreBundle\Document\Endpoint;


class LoadEndpointData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM\LoadSiteData',
        );
    }

    function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/');
        $ep1 = new Endpoint;
        $ep1->setParent($rt);
        $ep1->setTitle('ep1');
        $manager->persist($ep1);

        $ep2 = new Endpoint;
        $ep2->setParent($rt);
        $ep2->setTitle('ep2');
        $manager->persist($ep2);

        $ep3 = new Endpoint;
        $ep3->setParent($rt);
        $ep3->setTitle('ep3');
        $manager->persist($ep3);

        $manager->flush();
    }
}
