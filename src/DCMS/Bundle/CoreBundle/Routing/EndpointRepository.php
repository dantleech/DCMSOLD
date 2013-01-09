<?php

namespace DCMS\Bundle\CoreBundle\Routing;

use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Component\Config\Loader\LoaderInterface;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Site\SiteContext;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * TODO: Rename to RouteProvider
 */
class EndpointRepository implements RouteProviderInterface, ContainerAwareInterface
{
    protected $dm;
    protected $mm;
    protected $sm;
    protected $container;

    public function __construct(DocumentManager $dm, ModuleManager $mm, SiteContext $sm)
    {
        $this->dm = $dm;
        $this->mm = $mm;
        $this->sc = $sm;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $url = $request->getPathinfo();
        $isHomeRoute = false;

        if (!$url || $url == '/') {
            $ep = $this->sc->getSite()->getHomeEndpoint();
            $isHomeRoute = true;
        } else {
            $ep = $this->getEndpoint($url);
        }

        if (!$ep) {
            return null;
        }

        $epDef = $this->mm->getEndpointDefinition($ep);

        if (!$epDef) {
            throw new \Exception(sprintf('No endpoint definition for endpoint "%s" (url: %s)', get_class($ep), $url));
        }

        if (!$routingResource = $epDef->getRoutingResource()) {
            throw new \Exception('Endpoint has no routing resource set.');
        }

        $this->sc->setOnEndpoint(true);

        $loader = $this->container->get('routing.loader');
        $collection = $loader->load($routingResource);

        foreach ($collection as $route) {
            $route->setDefault('_endpoint', $ep);
        }

        // strip off PHPCR path
        $prefix = substr($ep->getId(), strlen($this->sc->getEndpointPath()));

        if (false === $isHomeRoute) {
            $collection->addPrefix($prefix);
        }

        return $collection;
    }

    protected function getEndpoint($url)
    {
        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }

        $parts = explode('/', $url);
        $first = array_shift($parts);

        $firstPath = $this->sc->getEndpointPath().'/'.$first;

        $ep = $this->dm->find(
            'DCMS\Bundle\CoreBundle\Document\Endpoint',
            $firstPath
        );

        if (null === $ep) {
            return null;
        }

        $currentNode = $ep->getNode();
        $currentNode = $ep->getNode();
        foreach ($parts as $part) {
            $children = $currentNode->getNodes();
            $match = false;
            foreach ($children as $child) {
                if ($child->getName() == $part) {
                    $currentNode = $child;
                    $match = true;
                }
            }

            if (false === $match) {
                break;
            }
        }

        $ep = $this->dm->getUnitOfWork()->createDocument('DCMS\Bundle\CoreBundle\Document\Endpoint', $currentNode);

        return $ep;
    }

    public function getRouteByName($name, $params = array())
    {
        throw new RouteNotFoundException();
    }

    public function getRoutesByNames($name, $params = array())
    {
        throw new RouteNotFoundException();
    }
}
