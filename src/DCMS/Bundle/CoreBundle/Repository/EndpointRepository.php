<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use DCMS\Bundle\CoreBundle\Document\Site;

class EndpointRepository extends DocumentRepository
{
    public function getEndpointsForSelect($epPath)
    {
        $forSelect = array();

        $endpoints = $this->getEndpoints($epPath);
        foreach ($endpoints as $endpoint) {
            $forSelect[$endpoint->getId()] = $endpoint->getTitle();
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
