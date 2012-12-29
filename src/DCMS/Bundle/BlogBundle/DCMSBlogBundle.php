<?php

namespace DCMS\Bundle\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class DCMSBlogBundle extends ModuleBundle
{
    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('blog');
        $m->createEndpointDefinition('DCMS\Bundle\BlogBundle\Document\BlogEndpoint')
            ->setController('DCMSBlogBundle:Blog:render')
            ->setTitle('Blog')
            ->setIcon('bundles/dcmsblog/images/blog-16.png');

        $m->createEndpointDefinition('DCMS\Bundle\BlogBundle\Document\Post')
            ->setTitle('Post')
            ->setController('DCMSBlogBundle:Post:render')
            ->setIcon('bundles/dcmsblog/images/blog-16.png');
    }
}
