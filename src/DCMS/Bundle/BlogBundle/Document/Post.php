<?php

namespace DCMS\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(
 *   referenceable=true,
 *   repositoryClass="DCMS\Bundle\BlogBundle\Repository\PostRepository"
 * )
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

    /**
     * @PHPCR\Boolean
     */
    protected $status;

    /**
     * @PHPCR\String(multivalue=true)
     */
    protected $tags = array();

    public function __construct()
    {
        $this->date = new \DateTime();
    }

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

    public function getBodyPreview($length = 255)
    {
        $suffix = strlen($this->body) > $length ? ' ...' : '';

        return substr($this->body, 0, 255).$suffix;
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

    public function getStatus()
    {
        return $this->status;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCsvTags()
    {
        $csvTags = '';
        if ($this->tags) {
            $csvTags = implode(',', (array) $this->tags);
        }
        return $csvTags;
    }
    
    public function setCsvTags($tags)
    {
        $tags = explode(',', $tags);
        foreach ($tags as &$tag) {
            $tag = trim($tag);
        }
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $uniq = array();
        foreach ($tags as $tag) {
            $uniq[$tag] = $tag;
        }
        $this->tags = array_values($uniq);
    }
}
