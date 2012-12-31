<?php

namespace DCMS\Bundle\MenuBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

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
     * @PHPCR\Children()
     */
    protected $items;

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

    public function setItems(MenuItem $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function addItem(MenuItem $item)
    {
        $item->setParent($this);
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }
}
