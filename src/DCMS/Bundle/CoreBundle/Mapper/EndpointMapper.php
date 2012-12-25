<?php

namespace DCMS\Bundle\CoreBundle\Mapper;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use Symfony\Cmf\Component\Routing\Mapper\ControllerMapperInterface;
use Symfony\Component\Routing\Route;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

class EndpointMapper implements ControllerMapperInterface
{
    protected $eps;
    protected $epContext;

    public function __construct(ModuleManager $mm, EpContext $epContext)
    {
        $this->eps = $mm->getEndpointDefinitions();
        $this->epContext = $epContext;
    }

    public function getController(Route $route, array &$defaults)
    {
        if ($endpoint = $route->getDefault('endpoint')) {
            foreach ($this->eps as $ep) {
                $contentFqn = $ep->getContentFQN();
                if (get_class($endpoint) == $ep->getContentFQN()) {
                    $this->epContext->setOnEndpoint(true);
                    return $ep->getController('render');
                }
            }
        }

        return false;
    }
}
