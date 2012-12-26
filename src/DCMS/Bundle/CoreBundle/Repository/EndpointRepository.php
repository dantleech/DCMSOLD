<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Component\Routing\Route;

class EndpointRepository extends DocumentRepository implements RouteRepositoryInterface
{
    public function findManyByUrl($url)
    {
        $qb = $this->dm->createQueryBuilder();
        $qf = $qb->getQOMFactory();
        $qb->from($qf->selector('dcms:endpoint'));
        $parts = explode('/', $url);
        $parts[] = $url;
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
