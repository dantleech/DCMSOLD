<?php

namespace DCMS\Bundle\MenuBundle\Menu;
use DCMS\Bundle\AdminBundle\Menu\ExtendMenuEvent;

class MenuMenu
{
    public function extendMenu(ExtendMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Menus', array('route' => 'dcms_menu_menu_index'));
    }
}

