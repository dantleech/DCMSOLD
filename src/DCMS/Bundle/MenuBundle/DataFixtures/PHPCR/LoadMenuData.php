<?php

namespace DCMS\Bundle\MenuBundle\DataFixtures\PHPCR;

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
            'home' => $manager->find(null, '/sites/dantleech.com/endpoints/home'),
            'cv' => $manager->find(null, '/sites/dantleech.com/endpoints/cv'),
            'finding-stray-commits' => $manager->find(null, '/sites/dantleech.com/endpoints/finding-stray-commits'),
            'me' => $manager->find(null, '/sites/dantleech.com/endpoints/about/me'),
            'them' => $manager->find(null, '/sites/dantleech.com/endpoints/about/them'),
            'about' => $manager->find(null, '/sites/dantleech.com/endpoints/about'),
        );

        $menu = new Menu;
        $menu->setTitle('Main Menu');
        $menu->setParent($rt);
        $rootItem = $this->createEpItem('__root__');
        $menu->setRootItem($rootItem);
        $rootItem->setParent($menu);
        $about = $rootItem->addChild($this->createEpItem('About', $docs['home']));
        $rootItem->addChild($this->createEpItem('Blog', $docs['home']));
        $rootItem->addChild($this->createEpItem('Archive', $docs['finding-stray-commits']));
        $rootItem->addChild($this->createEpItem('CV', $docs['cv']));
        $rootItem->addChild($about);
        $about->addChild($me = $this->createEpItem('Me', $docs['me']));
        $about->addChild($them = $this->createEpItem('Them', $docs['them']));

        $manager->persist($menu);
        $manager->flush();

        $menu = new Menu;
        $menu->setTitle('Footer Menu');
        $menu->setParent($rt);
        $rootItem = $this->createEpItem('__root__');
        $rootItem->setParent($menu);
        $menu->setRootItem($rootItem);
        $rootItem
            ->addChild($this->createEpItem('Contact', $docs['about']))
            ->addChild($this->createEpItem('CV', $docs['me']))
            ->addChild($this->createEpItem('About this site', $docs['them']));

        $manager->persist($menu);
        $manager->flush();
    }

    protected function createEpItem($title, $homeDoc = null)
    {
        $name = strtolower($title);
        $name .= '-item';
        $i = new MenuItem;
        $i->setName($name);
        $i->setLabel($title);
        if ($homeDoc) {
            $i->setContent($homeDoc);
        }
        return $i;
    }
}
