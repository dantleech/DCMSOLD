<?php

namespace DCMS\Bundle\CoreBundle\Module;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class ModuleBundle extends Bundle
{
    public function boot()
    {
        $ret = parent::boot();
        $mm = $this->container->get('dcms_core.module_manager');
        $this->setupModule($mm);
    }

    abstract protected function setupModule(ModuleManager $mm);
}
