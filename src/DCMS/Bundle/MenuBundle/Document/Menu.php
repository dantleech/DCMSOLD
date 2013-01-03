<?php

namespace DCMS\Bundle\MenuBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Menu
{
    /**
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\Uuid()
     */
    protected $uuid;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\NodeName()
     */
    protected $title;

    /**
     * @PHPCR\Child()
     */
    protected $rootItem;

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

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getRootItem()
    {
        if (!$this->rootItem) {
            $this->rootItem = new MenuItem;
            $this->rootItem->setName('0-item');
        }

        return $this->rootItem;
    }

    public function setRootItem(MenuItem $menuItem)
    {
        $this->rootItem = $menuItem;
    }
}
