<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Component\Config\Loader\LoaderInterface;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class EndpointRepository implements RouteRepositoryInterface
{
    protected $dm;
    protected $mm;
    protected $loader;

    public function __construct(DocumentManager $dm, ModuleManager $mm, LoaderInterface $loader)
    {
        $this->dm = $dm;
        $this->loader = $loader;
        $this->mm = $mm;
    }

    public function recursiveFindRoute($url)
    {
        $parts = explode('/', $url);
        $first = admay_shift($parts);
        $qb = $this->dm->createQueryBuilder();
        $qb->from($qf->selector('dcms:endpoint'));
        $qb->where(
            $qb->qmof()->comparison(
                $qb->qmof()->propertyValue('name'), 
                Constants::JCR_OPERATOR_EQUAL_TO, 
                $qf->literal($first)
            )
        );

        $eps = $qb->getQuery()->execute();

        if ($eps->count() == 0) {
            return null;
        }

        if (count($eps) == 1) {
            return $eps[0];
        }

        foreach ($parts as $ep) {

        }
    }

    public function findManyByUrl($url)
    {
        $qb = $this->dm->createQueryBuilder();
        $qb->from($qf->selector('dcms:endpoint'));
        foreach ($parts as $part) {
            if ('' === $part) {
                continue;
            }
            $qb->orWhere(
                $qf->andConstraint(
                    $qf->comparison(
                        $qf->propertyValue('path'), Constants::JCR_OPERATOR_EQUAL_TO, $qf->literal($part)
                    ),
                    $qf->comparison(
                        $qf->propertyValue('routeable'), Constants::JCR_OPERATOR_EQUAL_TO, $qf->literal(true)
                    )
                )
            );
        }

        $q = $qb->getQuery();
        $eps = $q->execute();

        $collection = new RouteCollection();
        foreach ($eps as $ep) {
            $route = new Route($ep->getFullPath(), array(
                'endpoint' => $ep,
            ));

            $collection->add('dcms_endpoint_'.uniqid(), $route);
        }

        return $collection;
    }

    public function getRouteByName($name, $params = array())
    {
        return null;
    }
}
