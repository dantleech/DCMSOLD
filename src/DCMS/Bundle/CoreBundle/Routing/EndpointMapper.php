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
    protected $mm;
    protected $epContext;

    public function __construct(ModuleManager $mm, EpContext $epContext)
    {
        $this->mm = $mm;
        $this->epContext = $epContext;
    }

    public function enhance(array $defaults, Request $request)
    {
        if ($endpoint = $defaults['endpoint']) {
            if ($epDef = $this->mm->getEndpointDefinition($endpoint)) {
                $this->epContext->setOnEndpoint(true);
                $defaults['_controller'] = $epDef->getRenderController();
            }
        }

        return $defaults;
    }
}
