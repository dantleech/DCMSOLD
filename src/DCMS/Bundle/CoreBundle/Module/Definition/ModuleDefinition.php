<?php

namespace DCMS\Bundle\CoreBundle\Module\Definition;

use DCMS\Bundle\CoreBundle\Module\Definition\EndpointDefinition;
use DCMS\Bundle\CoreBundle\Module\Exception\EndpointAlreadyDefined as EndpointAlreadyDefinedException;

class ModuleDefinition
{
    protected $name;
    protected $epds = array();

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addEndpointDefinition(EndpointDefinition $epd)
    {
        if (array_key_exists($epd->getEndpointFQN(), $this->epds)) {
            throw new EndpointAlreadyDefinedException($epd);
        }
        $this->epds[$epd->getEndpointFQN()] = $epd;

        return $this;
    }

    public function createEndpointDefinition($contentFQN)
    {
        $epd = new EndpointDefinition($contentFQN);
        $this->addEndpointDefinition($epd);
        return $epd;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEndpointDefinition($document)
    {
        foreach ($this->epds as $epd) {
            $fqn = $epd->getEndpointFQN();
            if (get_class($document) == $fqn) {
                return $epd;
            }
        }
    }
    
    public function getEndpointDefinitions()
    {
        return $this->epds;
    }
}
