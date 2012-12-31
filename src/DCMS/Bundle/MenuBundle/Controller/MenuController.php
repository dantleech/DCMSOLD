<?php

namespace DCMS\Bundle\MenuBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends DCMSController
{
    protected function getMenuRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\MenuBundle\Document\Menu');
    }

    protected function getMenu()
    {
        $menuUuid = $this->get('request')->get('menu_uuid');
        $menu = $this->getMenuRepo()->find($menuUuid);
        return $menu;
    }

    /**
     * @Route("/menu")
     * @Template()
     */
    public function indexAction()
    {
        $menus = $this->getMenurepo()->findAll();
        return array(
            'menus' => $menus
        );
    }

    /**
     * @Template()
     */
    public function _menuListAction()
    {
        $menus = $this->getMenurepo()->findAll();
        return array(
            'menus' => $menus
        );
    }

    /**
     * @Route("/menu/{menu_uuid}/edit")
     * @Template()
     */
    public function editAction()
    {
        $menu = $this->getMenu();
        return array(
            'menu' => $menu
        );
    }

    /**
     * @Route("/menu/{menu_uuid}/delete")
     */
    public function deleteAction()
    {
        $menu = $this->getMenu();
        try {
            $this->getDm()->remove($menu);
            $this->getDm()->flush();
            $this->getNotifier()->info('Menu "%s" deleted', array(
                $menu->getTitle(),
            )); 
            return $this->redirect($this->generateUrl('dcms_menu_menu_index', array(
            )));
        } catch (\Excmenution $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_menu_menu_edit', array(
                'menu_uuid' => $menu->getUuid(),
            )));
        }
    }
}

