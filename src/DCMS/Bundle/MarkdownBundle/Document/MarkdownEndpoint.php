<?php

namespace DCMS\Bundle\MarkdownBundle\Document;

use DCMS\Bundle\CoreBundle\Document\Endpoint;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;


/**
 * @PHPCR\Document()
 */
class MarkdownEndpoint extends Endpoint
{
    /**
     * @PHPCR\String()
     */
    protected $content;

    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
}
