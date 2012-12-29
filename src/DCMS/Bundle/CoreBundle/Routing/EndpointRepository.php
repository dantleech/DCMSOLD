<?php

namespace DCMS\Bundle\CoreBundle\Routing;

use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Component\Config\Loader\LoaderInterface;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Site\SiteManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EndpointRepository implements RouteRepositoryInterface, ContainerAwareInterface
{
    protected $dm;
    protected $mm;
    protected $sm;
    protected $container;

    public function __construct(DocumentManager $dm, ModuleManager $mm, SiteManager $sm)
    {
        $this->dm = $dm;
        $this->mm = $mm;
        $this->sm = $sm;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function findManyByUrl($url)
    {
        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }
        $parts = explode('/', $url);
        $first = array_shift($parts);
        $firstPath = $this->sm->getEndpointPath().'/'.$first;

        $ep = $this->dm->find(
            'DCMS\Bundle\CoreBundle\Document\Endpoint',
            $firstPath
        );

        if (null === $ep) {
            return null;
        }

        $currentNode = $ep->getNode();
        foreach ($parts as $part) {
            $currentNode = $ep->getNode();
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
        $epDef = $this->mm->getEndpointDefinition($ep);
        $routingResource = $epDef->getRoutingResource();
        $loader = $this->container->get('routing.loader');
        $collection = $loader->load($routingResource);

        foreach ($collection as $route) {
            $route->setDefault('_endpoint', $ep);
        }

        // strip off PHPCR path
        $prefix = substr($ep->getId(), strlen($this->sm->getEndpointPath()));
        $collection->addPrefix($prefix);
        return $collection;
    }

    public function getRouteByName($name, $params = array())
    {
        return null;
    }
}
