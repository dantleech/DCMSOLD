<?php

namespace DCMS\Bundle\BlogBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TagPost
{
    /**
     * @ORM\ManyToOne(targetEntity="DCMS\Bundle\BlogBundle\Entity\Tag", inversedBy="posts")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $tag;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string")
     */
    protected $postUuid;

    /**
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string")
     */
    protected $blogUuid;

    public function getId()
    {
        return $this->id;
    }

    public function getTag()
    {
        return $this->tag;
    }
    
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function getPostUuid()
    {
        return $this->postUuid;
    }
    
    public function setPostUuid($postUuid)
    {
        $this->postUuid = $postUuid;
    }

    public function getBlogUuid()
    {
        return $this->blogUuid;
    }
    
    public function setBlogUuid($blogUuid)
    {
        $this->blogUuid = $blogUuid;
    }
}
