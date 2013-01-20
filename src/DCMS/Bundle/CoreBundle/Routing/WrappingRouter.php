<?php

namespace DCMS\Bundle\CoreBundle\Routing;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router as SymfonyRouter;
use DCMS\Bundle\CoreBundle\Site\SiteContext;
use Symfony\Component\Routing\RequestContext;

/**
 * This class wraps the symfony router
 */
class WrappingRouter implements RouterInterface
{
    protected $sfRouter;
    protected $sc;

    public function __construct(SiteContext $sc, SymfonyRouter $sfRouter)
    {
        $this->sfRouter = $sfRouter;
        $this->sc = $sc;
    }

    /**
     * {@inheritDoc}
     *
     * Injects site_name automatically.
     */
    public function generate($name, $parameters = array(), $absolute = false)
    {
        if (!isset($parameters['site_name']) && $this->sc->hasSite()) {
            $parameters['site_name'] = $this->sc->getSite()->getName();
        }
        return $this->sfRouter->generate($name, $parameters, $absolute);
    }

    public function getContext()
    {
        return $this->sfRouter->getContext();
    }

    public function getRouteCollection()
    {
        return $this->sfRouter->getRouteCollection();
    }

    public function match($pathinfo)
    {
        $res = $this->sfRouter->match($pathinfo);

        if (isset($res['site_name'])) {
            $this->sc->setName($res['site_name']);
        }
        return $res;
    }

    public function setContext(RequestContext $context)
    {
        return $this->sfRouter->setContext($context);
    }
}
