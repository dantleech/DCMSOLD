<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Doctrine\ODM\PHPCR\DocumentRepository;

class EndpointRepository extends DocumentRepository implements RouteRepositoryInterface

{
    public function findManyByUrl($url)
    {
        $qb = $this->dm->createQueryBuilder();
        $qf = $qb->getQOMFactory();
        $qb->from($qf->selector('dcms:endpoint'));
        $qb->andWhere(
            $qf->comparison(
                $qf->propertyValue('path'), Constants::JCR_OPERATOR_EQUAL_TO, $qf->literal($url)
            )
        );
        $q = $qb->getQuery();
        $eps = $this->dm->getDocumentsByQuery($q);
        $collection = new RouteCollection();
        foreach ($eps as $ep) {
            $collection->add('dcms_endpoint_'.uniqid(), $ep);
        }

        return $collection;
    }

    public function getRouteByName($name, $params = array())
    {
        return null;
    }
}
