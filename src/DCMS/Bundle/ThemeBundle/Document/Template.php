<?php

namespace DCMS\Bundle\ThemeBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use DCMS\Bundle\CoreBundle\Validation\Constraints as RoutingValidation;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;

/**
 * @PHPCR\Document(referenceable=true, repositoryClass="DCMS\Bundle\ThemeBundle\Repository\TemplateRepository")
 */
class Template
{
    const TYPE_LAYOUT = 'layout';
    const TYPE_PARTIAL = 'partial';
    const TYPE_STYLESHEET = 'stylesheet';

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
     * @PHPCR\NodeName
     */
    protected $title;

    /**
     * @PHPCR\String()
     */
    protected $source;

    /**
     * @PHPCR\String()
     */
    protected $type;

    /**
     * @PHPCR\String
     */
    protected $resource;

    /**
     * @PHPCR\Date
     */
    protected $updatedAt;

    /**
     * @PHPCR\Date
     */
    protected $createdAt;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getSource()
    {
        return $this->source;
    }
    
    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @PHPCR\PreUpdate()
     * @PHPCR\PrePersist()
     */
    public function updateTs()
    {
        if (!$this->getUuid()) {
            $this->createdAt = new \DateTime();
        }

        $this->updatedAt = new \DateTime();
    }

    public function getResource()
    {
        return $this->resource;
    }
    
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
