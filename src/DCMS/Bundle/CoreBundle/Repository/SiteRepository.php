<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class SiteRepository extends DocumentRepository
{
    public function findByHost($host)
    {
        $qb = $this->createQueryBuilder();
        $qb->where($qb->expr()->eq('name', $name));
        $qb->setMaxResults(1);
        $q = $qb->getQuery();
        $site = $q->getOneOrNullResult();

        return $site;
    }
}

