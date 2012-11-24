<?php

namespace DCMS\Bundle\CoreBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use DCMS\Bundle\CoreBundle\Validation\Constraints as RoutingValidation;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;

/**
 * @PHPCR\Document(nodeType="dcms:endpoint",referenceable=true, repositoryClass="DCMS\Bundle\CoreBundle\Repository\EndpointRepository")
 */
class Endpoint
{
    /** 
     * @PHPCR\Id
     */
    protected $id;

    /**
     * @PHPCR\Uuid
     */
    protected $uuid;

    /** 
     * @PHPCR\ParentDocument
     */
    protected $parent;

    /**
     * @PHPCR\Children(filter="*")
     */
    protected $children;

    /** 
     * @PHPCR\NodeName
     */
    protected $nodeName;

    /**
     * @PHPCR\String()
     */
    protected $path;

    /**
     * @PHPCR\String()
     */
    protected $epClass;

    /**
     * @PHPCR\String(multivalue=true)
     */
    protected $parameters;

    public function __construct()
    {
        $this->addOptions(array());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getChildren()
    {
        return $this->children;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function addChild($child)
    {
        if (null === $this->children) {
            $this->children = new ArrayCollection();
        }
        $this->children->add($child);
    }

    public function getNodeName()
    {
        return $this->nodeName;
    }
    
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
    }

    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getEpClass()
    {
        return $this->epClass;
    }
    
    public function setEpClass($epClass)
    {
        $this->epClass = $epClass;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
}
