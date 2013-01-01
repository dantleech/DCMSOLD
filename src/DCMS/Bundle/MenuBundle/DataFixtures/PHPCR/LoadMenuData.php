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
        $rootItem->setParent($menu);
        $rootItem->addChild($this->createEpItem('content', $docs['home']));
        $rootItem->addChild($this->createEpItem('cv', $docs['cv']));
        $rootItem->addChild($this->createEpItem('finding-stray-commits', $docs['finding-stray-commits']));
        $about = $this->createEpItem('About', $docs['about']);
        $rootItem->addChild($about);
        $about->addChild($me = $this->createEpItem('Me', $docs['me']));
        $about->addChild($them = $this->createEpItem('Them', $docs['them']));
        $menu->setRootItem($rootItem);

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
