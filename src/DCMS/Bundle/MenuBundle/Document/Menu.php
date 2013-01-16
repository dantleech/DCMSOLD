<?php

namespace DCMS\Bundle\MenuBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use DCMS\Bundle\CoreBundle\Util\DocumentUtils;

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
     * @PHPCR\String()
     */
    protected $title;

    /**
     * @PHPCR\NodeName()
     */
    protected $name;

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
        $this->name = DocumentUtils::slugify($title);
    }

    public function getRootItem()
    {
        if (!$this->rootItem) {
            $this->rootItem = new MenuItem;
            $this->rootItem->setName('0-item');
        }

        return $this->rootItem;
    }

    public function setRootItem($menuItem)
    {
        $this->rootItem = $menuItem;
    }
}