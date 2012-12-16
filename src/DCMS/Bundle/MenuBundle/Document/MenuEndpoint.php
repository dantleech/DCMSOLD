<?php

namespace DCMS\Bundle\MenuBundle\Document;

use DCMS\Bundle\CoreBundle\Document\Endpoint;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;


/**
 * @PHPCR\Document()
 */
class MenuEndpoint extends Endpoint
{
    public function __construct()
    {
        $this->routeable = false;
    }
}

