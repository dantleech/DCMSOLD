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
            ->setTitle('Blog')
            ->setIcon('bundles/dcmsblog/images/blog-16.png')
            ->setRenderController('DCMSBlogBundle:Blog:render')
            ->setRoutingResource('@DCMSBlogBundle/Resources/config/routing/blog_endpoint.yml');

        $m->createEndpointDefinition('DCMS\Bundle\BlogBundle\Document\Post')
            ->setTitle('Post')
            ->setIcon('bundles/dcmsblog/images/blog-16.png')
            ->setRoutingResource('@DCMSBlogBundle/Resources/config/routing/blog_post.yml');
    }
}
