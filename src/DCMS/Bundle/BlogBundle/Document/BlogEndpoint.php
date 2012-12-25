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

    public function getPosts()
    {
        return $this->posts;
    }
}
