<?php

namespace DCMS\Bundle\CoreBundle\Site\Exception;

class FolderDoesNotExist extends \Exception
{
    public function __construct($class)
    {
        $message = sprintf(
            'Folder name not set for document class "%s"', 
            $class
        );
        parent::__construct($message);
    }
}
