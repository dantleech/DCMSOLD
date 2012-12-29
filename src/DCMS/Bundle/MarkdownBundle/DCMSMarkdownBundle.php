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
            ->setTitle('Markdown')
            ->setController('DCMSMarkdownBundle:Endpoint:edit')
            ->setFormTypes(array(
                'edit' => 'DCMS\Bundle\MarkdownBundle\Form\EndpointType',
            ))
            ->setJavascriptDependencies(array(
                'edit' => array(
                    'bundles/dcmsmarkdown/js/pagedown/Markdown.Converter.js',
                    'bundles/dcmsmarkdown/js/pagedown/Markdown.Sanitizer.js',
                    'bundles/dcmsmarkdown/js/pagedown/Markdown.Editor.js',
                ),
            ))
            ->setStylesheetDependencies(array(
                'edit' => array(
                    'bundles/dcmsmarkdown/css/pagedown.css',
                )
            ))
            ->setIcon('bundles/dcmsmarkdown/images/markdown-16.png');
    }
}
