<?php

namespace DCMS\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Post
{
    /**
     * @PHPCR\Uuid
     */
    protected $uuid;

    /**
     * @PHPCR\NodeName
     */
    protected $slug;

    /**
     * @PHPCR\String()
     */
    protected $title;

    /**
     * @PHPCR\String()
     */
    protected $body;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\Date()
     */
    protected $date;

    /**
     * @PHPCR\ReferenceOne(
     *   targetDocument="DCMS\Bundle\BlogBundle\Document\BlogEndpoint",
     *   strategy="hard"
     * )
     */
    protected $blog;

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @PHPCR\PreUpdate
     * @PHPCR\PrePersist
     */
    public function updateSlug()
    {
        setlocale(LC_CTYPE, 'fr_FR.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $this->title);
        $clean = strip_tags($clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        if (substr($clean, -1) == '-') {
            $clean = substr($clean, 0, -1);
        }

        $this->slug = $clean;
    }

    public function getDate()
    {
        return $this->date;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getBlog()
    {
        return $this->blog;
    }
    
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }
}
