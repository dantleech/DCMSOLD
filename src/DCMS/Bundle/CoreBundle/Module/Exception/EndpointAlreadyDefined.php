<?php

namespace DCMS\Bundle\CoreBundle\Module\Exception;
use DCMS\Bundle\CoreBundle\Module\Definition\EndpointDefinition;

class EndpointAlreadyDefined extends \Exception
{
    public function __construct(EndpointDefinition $module)
    {
        $message = sprintf('Endpoint for document "%s" has already been defined', $module->getEndpointFQN());
        return parent::__construct($message);
    }
}
