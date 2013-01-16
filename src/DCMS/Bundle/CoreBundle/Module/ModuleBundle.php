<?php

namespace DCMS\Bundle\CoreBundle\Module;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;

abstract class ModuleBundle extends Bundle
{
    public function boot()
    {
        $ret = parent::boot();
        $mm = $this->container->get('dcms_core.module_manager');
        $this->setupModule($mm);

        $dm = $this->container->get('dcms_core.document_organizer');
        $this->organizeDocuments($dm);
    }

    abstract protected function setupModule(ModuleManager $mm);

    protected function organizeDocuments(DocumentOrganizer $do)
    {
    }
}
