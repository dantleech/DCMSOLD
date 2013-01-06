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
     * @PHPCR\Referrers()
     */
    protected $posts;

    /**
     * @PHPCR\ReferenceOne(strategy="hard")
     */
    protected $postsFolder;

    public function getPosts()
    {
        return $this->posts;
    }

    public function getPostsFolder()
    {
        return $this->postsFolder;
    }
    
    public function setPostsFolder($postsFolder)
    {
        $this->postsFolderName = $postsFolder;
    }
}
