<?php

namespace DCMS\Bundle\BlogBundle\Menu;
use DCMS\Bundle\AdminBundle\Menu\ExtendMenuEvent;

class BlogMenu
{
    public function extendMenu(ExtendMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('Posts', array('route' => 'dcms_blog_post_index'));
    }
}

