<?php

namespace DCMS\Bundle\ThemeBundle\Menu;
use DCMS\Bundle\AdminBundle\Menu\ExtendMenuEvent;

class ThemeMenu
{
    public function extendMenu(ExtendMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Templates', array('route' => 'dcms_theme_template_index'));
    }
}

