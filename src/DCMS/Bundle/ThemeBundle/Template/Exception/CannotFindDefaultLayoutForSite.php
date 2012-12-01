<?php

namespace DCMS\Bundle\ThemeBundle\Template\Exception;

class CannotFindDefaultLayoutForSite extends \Exception
{
    public function __construct($site)
    {
        $message = sprintf('Cannot find default template for site: %s', $site->getId());
        parent::__construct($message);
    }
}
