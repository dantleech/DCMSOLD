<?php

namespace DCMS\Bundle\CoreBundle\Module\Definition;

class EndpointDefinition
{
    protected $documentFqn;
    protected $icon;
    protected $title;

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

    public function getDocumentFQN()
    {
        return $this->documentFqn;
    }
}
