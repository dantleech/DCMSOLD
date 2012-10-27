<?php

namespace DCMS\Bundle\CoreBundle\Module\Definition;

class EndpointDefinition
{
    protected $documentFqn;
    protected $icon;
    protected $title;

    protected $validTypes = array(
        'edit', // edit page for endpoint editor
    );

    protected $controllers = array();
    protected $javascriptDependencies = array();

    public function __construct($documentFqn)
    {
        $this->documentFqn = $documentFqn;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getDocumentFQN()
    {
        return $this->documentFqn;
    }

    public function setControllers(array $controllers)
    {
        $this->controllers = $controllers;
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
}
