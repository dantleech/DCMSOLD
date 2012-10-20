<?php

namespace DCMS\Bundle\MarkdownBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DCMSMarkdownBundle extends Bundle
{
    public function initModule(ModuleManager $mm)
    {
        $m = $mm->createModule('markdown');
        $m->createEndpointDefinition('markdown', 'DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint')
            ->setIcon('bundles/dcmsmarkdown/images/icon/markdown.png');
    }
}
