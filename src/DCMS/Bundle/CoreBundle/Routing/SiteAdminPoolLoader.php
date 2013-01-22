<?php

namespace DCMS\Bundle\CoreBundle\Routing;

use Symfony\Component\Routing\RouteCollection as SymfonyRouteCollection;
use Symfony\Component\Routing\Route;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;

use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sonata\AdminBundle\Route\AdminPoolLoader;
use DCMS\Bundle\CoreBundle\Site\SiteContext;

class SiteAdminPoolLoader extends AdminPoolLoader
{
    protected $sc;

    public function setSiteContext(SiteContext $sc)
    {
        $this->sc = $sc;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($resource, $type = null)
    {
        if ($type == 'dcms_site_admin') {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function load($resource, $type = null)
    {
        $collection = parent::load($resource, $type);
        foreach ($collection as $route) {
            $pattern = sprintf('/{site_name}%s', $route->getPattern());
            $route->setPattern($pattern);
        }

        return $collection;
    }
}
