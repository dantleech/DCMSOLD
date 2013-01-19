<?php

namespace DCMS\Bundle\CoreBundle\DependencyInjection\Compiler;

use Sonata\AdminBundle\DependencyInjection\Compiler\AddDependencyCallsCompilerPass as BaseAddDependencyCallsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Get all dcms.site_admin Admin classes and configure them.
 */
class AddDependencyCallsCompilerPass extends BaseAddDependencyCallsCompilerPass
{
    /**
     * @todo: This method repeats way to much stuff. The only things changed
     *        are "dcms.site_admin" and "dcms.admin.site_route_loader". If this
     *        turns out ot be a valid thing to so, see about making a PR.
     */
    public function process(ContainerBuilder $container)
    {
        $groupDefaults = $admins = $classes = array();

        $pool = $container->getDefinition('dcms.admin.pool');

        foreach ($container->findTaggedServiceIds('dcms.site_admin') as $id => $tags) {

            foreach ($tags as $attributes) {
                $definition = $container->getDefinition($id);

                // START: DCMS Specific
                $definition->addMethodCall('setDocumentOrganizer', array(new Reference('dcms_core.document_organizer')));
                $definition->addMethodCall('setModuleManager', array(new Reference('dcms_core.module_manager')));
                $definition->addMethodCall('setRouteBuilder', array(new Reference('sonata.admin.route.path_info_slashes')));
                // END: DCMS Specific


                $arguments = $definition->getArguments();

                if (strlen($arguments[0]) == 0) {
                    $definition->replaceArgument(0, $id);
                }

                if (strlen($arguments[2]) == 0) {
                    $definition->replaceArgument(2, 'SonataAdminBundle:CRUD');
                }

                $this->applyConfigurationFromAttribute($definition, $attributes);
                $this->applyDefaults($container, $id, $attributes);

                $arguments = $definition->getArguments();

                $admins[] = $id;
                $classes[$arguments[1]] = $id;

                $showInDashboard = (boolean)(isset($attributes['show_in_dashboard']) ? $attributes['show_in_dashboard'] : true);
                if (!$showInDashboard) {
                    continue;
                }

                $groupName = isset($attributes['group']) ? $attributes['group'] : 'default';
                $labelCatalogue = isset($attributes['label_catalogue']) ? $attributes['label_catalogue'] : 'SonataAdminBundle';

                if (!isset($groupDefaults[$groupName])) {
                    $groupDefaults[$groupName] = array(
                        'label'           => $groupName,
                        'label_catalogue' => $labelCatalogue
                    );
                }

                $groupDefaults[$groupName]['items'][] = $id;
            }
        }

        $dashboardGroupsSettings = $container->getParameter('sonata.admin.configuration.dashboard_groups');
        if (!empty($dashboardGroupsSettings)) {
            $groups = $dashboardGroupsSettings;

            foreach ($dashboardGroupsSettings as $groupName => $group) {
                if (!isset($groupDefaults[$groupName])) {
                    $groupDefaults[$groupName] = array(
                        'items' => array(),
                        'label' => $groupName
                    );
                }

                if (empty($group['items'])) {
                    $groups[$groupName]['items'] = $groupDefaults[$groupName]['items'];
                }

                if (empty($group['label'])) {
                    $groups[$groupName]['label'] = $groupDefaults[$groupName]['label'];
                }

                if (empty($group['label_catalogue'])) {
                    $groups[$groupName]['label_catalogue'] = 'SonataAdminBundle';
                }

                if (!empty($group['item_adds'])) {
                    $group['items'] = array_merge($groupDefaults[$groupName]['items'], $group['item_adds']);
                }
            }
        } else {
            $groups = $groupDefaults;
        }

        $pool->addMethodCall('setAdminServiceIds', array($admins));
        $pool->addMethodCall('setAdminGroups', array($groups));
        $pool->addMethodCall('setAdminClasses', array($classes));

        $routeLoader = $container->getDefinition('dcms.admin.site_route_loader');
        $routeLoader->replaceArgument(1, $admins);
    }
}
