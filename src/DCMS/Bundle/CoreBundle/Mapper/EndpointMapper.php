<?php

namespace DCMS\Bundle\CoreBundle\Mapper;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use Symfony\Cmf\Component\Routing\Mapper\ControllerMapperInterface;
use Symfony\Component\Routing\Route;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

class EndpointMapper implements ControllerMapperInterface
{
    protected $eps;

    public function __construct(ModuleManager $mm)
    {
        $this->eps = $mm->getEndpointDefinitions();
    }

    public function getController(Route $route, array &$defaults)
    {
        if ($endpoint = $route->getDefault('endpoint')) {
            foreach ($this->eps as $ep) {
                $contentFqn = $ep->getContentFQN();
                if (get_class($endpoint) == $ep->getContentFQN()) {
                    return $ep->getController('render');
                }
            }
        }

        return false;
    }
}
