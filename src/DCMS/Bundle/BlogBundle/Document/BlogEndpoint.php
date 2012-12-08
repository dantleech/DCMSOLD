<?php

namespace DCMS\Bundle\BlogBundle\Document;

use DCMS\Bundle\CoreBundle\Document\Endpoint;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document
 */
class BlogEndpoint extends Endpoint
{
    /**
     * @PHPCR\ReferenceMany(targetDocument="DCMS\Bundle\BlogBundle\Document\Post")
     */
    protected $posts;

    public function getPosts()
    {
        return $this->posts;
    }
    
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
}
