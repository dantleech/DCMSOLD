<?php

namespace DCMS\Bundle\CoreBundle\Module\Definition;

class EndpointDefinition
{
    protected $endpointFQN;
    protected $icon;
    protected $title;

    protected $validTypes = array(
        'edit', // edit page for endpoint editor
        'render',
    );

    protected $controller;

    protected $formTypes = array(
        'edit' => 'DCMS\Bundle\CoreBundle\Form\BaseEndpointType',
    );

    protected $javascriptDependencies = array(
        'edit' => array(),
    );

    protected $stylesheetDependencies = array(
        'edit' => array(),
    );

    public function __construct($endpointFQN)
    {
        $this->endpointFQN = $endpointFQN;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getEndpointFQN()
    {
        return $this->endpointFQN;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setJavascriptDependencies(array $jsDeps)
    {
        $this->javascriptDependencies = $jsDeps;
        return $this;
    }

    public function getJavascriptDependencies($type)
    {
        return $this->javascriptDependencies[$type];
    }

    public function getStylesheetDependencies($type)
    {
        return $this->stylesheetDependencies[$type];
    }
    
    public function setStylesheetDependencies($stylesheetDependencies)
    {
        $this->stylesheetDependencies = $stylesheetDependencies;
        return $this;
    }

    public function getFormType($type)
    {
        return $this->formTypes[$type];
    }
    
    public function setFormTypes($formTypes)
    {
        $this->formTypes = $formTypes;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setRoutingResource($resource)
    {
        $this->routingResource = $resource;
        return $this;
    }

    public function getRoutingResource()
    {
        return $this->routingResource;
    }
}
