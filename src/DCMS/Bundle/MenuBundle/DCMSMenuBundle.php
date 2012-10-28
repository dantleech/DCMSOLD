<?php

namespace DCMS\Bundle\MenuBundle;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;

class DCMSMenuBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('menu');
        $m->createEndpointDefinition('DCMS\Bundle\MenuBundle\Document\MenuEndpoint')
            ->setControllers(array(
                'edit' => 'DCMSMenuBundle:Endpoint:edit',
            ))
            ->setIcon('bundles/dcmsmenu/images/menu-16.png');
    }
}
