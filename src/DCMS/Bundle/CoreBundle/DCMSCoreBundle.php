<?php

namespace DCMS\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;

class DCMSCoreBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('core');
        $m->createEndpointDefinition('DCMS\Bundle\CoreBundle\Document\Endpoint')
            ->setTitle('Default')
            ->setRoutingResource('@DCMSCoreBundle/Resources/config/routing/endpoint.yml');
    }
}
