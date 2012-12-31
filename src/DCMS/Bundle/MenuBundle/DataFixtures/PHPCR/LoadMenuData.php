<?php

namespace DCMS\Bundle\AdminBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DCMS\Bundle\MenuBundle\Document\Menu;
use DCMS\Bundle\MenuBundle\Document\MenuItem;

class LoadMenuData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
            'DCMS\Bundle\MarkdownBundle\DataFixtures\PHPCR\LoadEndpointData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/sites/dantleech.com/menus');
        $docs = array(
            'Home' => $manager->find(null, '/sites/dantleech.com/endpoints/home'),
            'Cv' => $manager->find(null, '/sites/dantleech.com/endpoints/cv'),
            'Finding stray commits' => $manager->find(null, '/sites/dantleech.com/endpoints/finding-stray-commits'),
            'Me' => $manager->find(null, '/sites/dantleech.com/endpoints/about/me'),
            'Them' => $manager->find(null, '/sites/dantleech.com/endpoints/about/them'),
            'About' => $manager->find(null, '/sites/dantleech.com/endpoints/about'),
        );

        $items = array();
        foreach ($docs as $title => $doc) {
            $items[$title] = $this->createEpItem($title, $doc);
        }

        $menu = new Menu;
        $menu->setParent($rt);
        $menu->setTitle('Main Menu');
        $menu->addItem($items['Home']);
        $menu->addItem($items['Cv']);
        $items['Me']->setParent($items['About']);
        $items['Them']->setParent($items['About']);
        $menu->addItem($items['About']);

        // because cascading doesn't seem to work
        $manager->persist($items['Me']);
        $manager->persist($items['Them']);

        $menu->addItem($items['Finding stray commits']);
        $manager->persist($menu);

        $menu = new Menu;
        $menu->setParent($rt);
        $menu->setTitle('Secondary Menu');
        $manager->persist($menu);

        $manager->flush();
    }

    protected function createEpItem($title, $homeDoc)
    {
        $name = strtolower($title);
        $name .= '-item';
        $i = new MenuItem;
        $i->setName($name);
        $i->setLabel($title);
        $i->setContent($homeDoc);
        return $i;
    }
}
