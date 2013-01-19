<?php


namespace DCMS\Bundle\CoreBundle\Module;

use DCMS\Bundle\CoreBundle\Module\Definition\ModuleDefinition;

class ModuleManager
{
    protected $modules = array();

    public function createModule($name)
    {
        $this->
        $module = new ModuleDefinition($name);
        $this->registerModule($module);
        $this->:Pr

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

    /**
     * Retrieve the definition for the given Document
     *
     * @param object
     *
     * @return EndpointDefinition
     */
    public function getEndpointDefinition($document)
    {
        foreach ($this->modules as $module) {
            if ($epd = $module->getEndpointDefinition($document)) {
                return $epd;
            }
        }
    }

    public function getEndpointDefinitions()
    {
        $eps = array();

        foreach ($this->modules as $module) {
            foreach ($module->getEndpointDefinitions() as $ep) {
                $eps[] = $ep;
            }
        }

        return $eps;
    }

    public function getEndpointsForSelect()
    {
        $epsForSelect = array();

        foreach ($this->getEndpointDefinitions() as $epDef) {
            $epsForSelect[$epDef->getEndpointFQN()] = $epDef->getTitle();
        }

        return $epsForSelect;
    }
}
