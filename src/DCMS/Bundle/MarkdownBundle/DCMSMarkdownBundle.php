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
            ->setControllers(array(
                'edit' => 'DCMSMarkdownBundle:Endpoint:edit',
            ))
            ->setJavascriptDependencies(array(
                'edit' => array(
                    'bundles/dcmsmarkdown/js/epic-editor/epiceditor/js/epiceditor.js',
                ),
            ))
            ->setIcon('bundles/dcmsmarkdown/images/markdown-16.png');
    }
}
