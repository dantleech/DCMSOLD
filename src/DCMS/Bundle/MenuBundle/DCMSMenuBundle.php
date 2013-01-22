<?php

namespace DCMS\Bundle\MenuBundle;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;
use DCMS\Bundle\CoreBundle\Organizer\DocumentOrganizer;

class DCMSMenuBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('menu');
    }

    protected function organizeDocuments(DocumentOrganizer $do)
    {
        $do->register('DCMS\Bundle\MenuBundle\Document\Menu', '@site:/menus');
    }
}
