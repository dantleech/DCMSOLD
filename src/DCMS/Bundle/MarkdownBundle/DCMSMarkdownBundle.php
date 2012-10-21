<?php

namespace DCMS\Bundle\MarkdownBundle;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;

class DCMSMarkdownBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('markdown');
        $m->createEndpointDefinition('DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint')
            ->setIcon('bundles/dcmsmarkdown/images/markdown-16.png');
    }
}
