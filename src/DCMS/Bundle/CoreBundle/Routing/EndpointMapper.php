<?php

namespace DCMS\Bundle\CoreBundle\Routing;

use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use Symfony\Cmf\Component\Routing\Enhancer\RouteEnhancerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Component\HttpFoundation\Request;

class EndpointMapper implements RouteEnhancerInterface 
{
    protected $eps;
    protected $epContext;

    public function __construct(ModuleManager $mm, EpContext $epContext)
    {
        $this->eps = $mm->getEndpointDefinitions();
        $this->epContext = $epContext;
    }

    public function enhance(array $defaults, Request $request)
    {
        if ($endpoint = $defaults['endpoint']) {
            foreach ($this->eps as $ep) {
                $contentFqn = $ep->getContentFQN();
                if (get_class($endpoint) == $ep->getContentFQN()) {
                    $this->epContext->setOnEndpoint(true);
                    $defaults['_controller'] = $ep->getController('render');
                }
            }
        }

        return $defaults;
    }
}
