<?php

namespace DCMS\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;
use DCMS\Bundle\CoreBundle\DependencyInjection\Compiler\AdminPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;

class DCMSCoreBundle extends ModuleBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminPass());
    }

    protected function setupModule(ModuleManager $mm)
    {
        $m = $mm->createModule('core');
        $m->createEndpointDefinition('DCMS\Bundle\CoreBundle\Document\Endpoint')
            ->setTitle('Default')
            ->setRoutingResource('@DCMSCoreBundle/Resources/config/routing/endpoint.yml');
    }

    protected function organizeDocuments(DocumentOrganizer $do)
    {
        $do->documentsOfClass('DCMS\Bundle\CoreBundle\Document\Endpoint')
            ->belongInFolder('endpoints');
    }
}