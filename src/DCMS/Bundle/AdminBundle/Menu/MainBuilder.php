<?php

namespace DCMS\Bundle\AdminBundle\Menu;
use Symfony\Component\DependencyInjection\ContainerAware;
use DCMS\Bundle\AdminBundle\Menu\ExtendMenuEvent;
use Knp\Menu\FactoryInterface;

class MainBuilder extends ContainerAware
{
    public function build(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Home', array('route' => 'dcms_admin_default_index'));
        $menu->addChild('Pages', array('route' => 'dcms_admin_endpoint_index'));

        $this->container->get('event_dispatcher')->dispatch(
            ExtendMenuEvent::EXTEND, 
            new ExtendMenuEvent($factory, $menu)
        );

        return $menu;
    }
}
