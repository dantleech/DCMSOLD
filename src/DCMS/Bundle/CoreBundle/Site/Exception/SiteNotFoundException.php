<?php

namespace DCMS\Bundle\CoreBundle\Site\Exception;

class SiteNotFoundException extends \Exception
{
    public function __construct($sitePath)
    {
        $message = sprintf('Site with path "%s" not found', $sitePath);
        parent::__construct($message);
    }
}
