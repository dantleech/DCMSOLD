<?php

namespace DCMS\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AdminPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('dcms_core.document_organizer')) {
            return;
        }

        // register additional template loaders
        $defIds = $container->findTaggedServiceIds('dcms.admin');

        foreach ($defIds as $defId => $config) {
		    $def = $container->getDefinition($defId);
            $def->addMethodCall('setDocumentOrganizer', array(new Reference('dcms_core.document_organizer')));
            $def->addMethodCall('setRouteBuilder', array(new Reference('sonata.admin.route.path_info_slashes')));
            
        }
    }
}
