<?php

namespace DCMS\Bundle\AdminBundle\Tests\Fixtures\ODM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DCMS\Bundle\RoutingBundle\Document\Endpoint;


class LoadEndpointData implements FixtureInterface
{
    function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/');
        $ep1 = new Endpoint;
        $ep1->setParent($rt);
        $ep1->setNodeName('ep1');
        $ep1->setPath('/ep1');
        $manager->persist($ep1);

        $ep2 = new Endpoint;
        $ep2->setParent($rt);
        $ep2->setNodeName('ep2');
        $ep2->setPath('/ep2');
        $manager->persist($ep2);

        $ep3 = new Endpoint;
        $ep3->setParent($rt);
        $ep3->setNodeName('ep3');
        $ep3->setPath('/ep3');
        $manager->persist($ep3);

        $manager->flush();
    }
}
