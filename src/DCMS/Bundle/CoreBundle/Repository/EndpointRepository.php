<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use DCMS\Bundle\CoreBundle\Document\Site;

class EndpointRepository extends DocumentRepository
{
    public function getEndpointsForSelect($epPath, $truncate = 25)
    {
        $forSelect = array();

        $endpoints = $this->getEndpoints($epPath);
        foreach ($endpoints as $endpoint) {
            $forSelect[$endpoint->getId()] = substr($endpoint->getId(), strlen($epPath));
        }

        return $forSelect;
    }

    public function getEndpoints($epPath)
    {
        $qb = $this->createQueryBuilder();
        $endpoints = $qb->where($qb->qomf()->descendantNode($epPath))
            ->execute();

        return $endpoints;
    }
}
