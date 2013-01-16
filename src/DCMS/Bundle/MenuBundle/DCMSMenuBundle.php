<?php

namespace DCMS\Bundle\MenuBundle;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;

class DCMSMenuBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('menu');
    }

    protected function organizeDocuments(DocumentOrganizer $do)
    {
        $do->documentsOfClass('DCMS\Bundle\MenuBundle\Document\Menu')
            ->belongInFolder('menus');
    }
}
