<?php

namespace DCMS\Bundle\CoreBundle\Module\Exception;
use DCMS\Bundle\CoreBundle\Module\Definition\ModuleDefinition;

class ModuleAlreadyDefined extends \Exception
{
    public function __construct(ModuleDefinition $module)
    {
        $message = sprintf('Module "%s" has already been defined', $module->GetName());
        return parent::__construct($message);

        $this->php
    }
}
