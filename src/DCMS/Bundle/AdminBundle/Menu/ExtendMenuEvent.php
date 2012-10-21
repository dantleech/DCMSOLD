<?php

namespace DCMS\Bundle\AdminBundle\Menu;

use Symfony\Component\EventDispatcher\Event;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class ExtendMenuEvent extends Event
{
    const EXTEND = 'dcms_admin.menu_extend';

    private $factory;
    private $menu;

    public function __construct(FactoryInterface $factory, ItemInterface $menu)
    {
        $this->factor = $factory;
        $this->menu = $menu;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function getMenu()
    {
        return $this->menu;
    }
}
