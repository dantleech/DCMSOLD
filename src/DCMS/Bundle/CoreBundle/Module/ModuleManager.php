<?php

namespace DCMS\Bundle\CoreBundle\Module;

use DCMS\Bundle\CoreBundle\Module\Definition\ModuleDefinition;

class ModuleManager
{
    protected $modules = array();

    public function createModule($name)
    {
        $module = new ModuleDefinition($name);
        $this->registerModule($module);

        return $module;
    }

    public function registerModule($module)
    {
        if (array_key_exists($module->getName(), $this->modules)) {
            throw new Exception\ModuleAlreadyDefined($module);
        }

        $this->modules[$module->getName()] = $module;
    }

    public function getRegisteredModuleNames()
    {
        return array_keys($this->modules);
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getEndpointDefinition($documentFqn)
    {
        foreach ($this->modules as $module) {
            if ($epd = $module->getEndpointDefinition($documentFqn)) {
                return $epd;
            }
        }
    }
}
