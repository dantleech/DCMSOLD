<?php

namespace DCMS\Bundle\CoreBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Doctrine\Common\Util\ClassUtils;

/**
 * @PHPCR\Document
 */
class Folder
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

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getNodeName()
    {
        return $this->nodeName;
    }
    
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
    }

    public function getChildren($filterClass = null)
    {
        $children = $this->children;
        if ($filterClass) {
            $ret = array();
            foreach ($children as $child) {
                if ($child instanceOf $filterClass) {
                    $ret[] = $child;
                }
            }
            $children = $ret;
        }
        return $children;
    }

    public function addChild($child)
    {
        $this->children[] = $child;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }
}

