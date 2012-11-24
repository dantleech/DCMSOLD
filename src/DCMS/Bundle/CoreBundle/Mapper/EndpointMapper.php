<?php

namespace DCMS\Bundle\CoreBundle\Mapper;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use Symfony\Cmf\Component\Routing\Mapper\ControllerMapperInterface;
use Symfony\Component\Routing\Route;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

class EndpointMapper implements ControllerMapperInterface
{
    protected $eps;

    public function __cosntruct(ModuleManager $mm)
    {
        $this->eps = $mm->getEndpointDefinitions();
    }

    public function getController(Route $route, array &$defaults)
    {
        if (!$route instanceof RouteObjectInterface) {
            return false;
        }

        $route->getRouteContent();
        foreach ($eps as $ep) {
            $contentFqn = $ep->getContentFQN();
            if ($content instanceof $contentFqn) {
                return $ep->getController('render');
            }
        }

        return false;
    }
}
