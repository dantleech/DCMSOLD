<?php

namespace DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\CoreBundle\Document\Site;
use DCMS\Bundle\CoreBundle\Document\TestEndpoint as Endpoint;

class LoadEndpointData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM\LoadSiteData'
        );
    }

    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/sites/dantleech.com/endpoints');

        $home = new Endpoint;
        $home->setParent($rt);
        $home->setTitle('Home');
        $manager->persist($home);

        $contact = new Endpoint;
        $contact->setParent($home);
        $contact->setTitle('Contact');
        $manager->persist($contact);

        $cv = new Endpoint;
        $cv->setParent($contact);
        $cv->setTitle('Cv');
        $manager->persist($cv);

        $manager->flush();

        // set home
        $site = $manager->find(null, '/sites/dantleech.com');
        $site->setHomeEndpoint($home);
        $manager->persist($home);
        $manager->flush();
    }
}
