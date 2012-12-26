<?php

namespace DCMS\Bundle\CoreBundle\Module\Definition;

class EndpointDefinition
{
    protected $contentFQN;
    protected $icon;
    protected $title;

    protected $validTypes = array(
        'edit', // edit page for endpoint editor
        'render',
    );

    protected $controllers = array(
        'edit' => null,
        'render' => null,
    );

    protected $formTypes = array(
        'edit' => 'DCMS\Bundle\CoreBundle\Form\BaseEndpointType',
    );

    protected $javascriptDependencies = array(
        'edit' => array(),
    );

    protected $stylesheetDependencies = array(
        'edit' => array(),
    );

    public function __construct($contentFQN)
    {
        $this->contentFQN = $contentFQN;
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

    public function getContentFQN()
    {
        return $this->contentFQN;
    }

    public function setControllers(array $controllers)
    {
        $this->controllers = array_merge($this->controllers, $controllers);
        return $this;
    }

    public function getController($type)
    {
        return $this->controllers[$type];
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
}
