<?php

namespace DCMS\Bundle\CoreBundle;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Module\ModuleBundle;
use DCMS\Bundle\CoreBundle\DependencyInjection\Compiler\AddDependencyCallsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use DCMS\Bundle\CoreBundle\Organizer\DocumentOrganizer;

class DCMSCoreBundle extends ModuleBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddDependencyCallsCompilerPass());
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
        $do->register('DCMS\Bundle\CoreBundle\Document\Site', '/sites');
        $do->register('DCMS\Bundle\CoreBundle\Document\Endpoint', '@site:/endpoints');
    }
}
