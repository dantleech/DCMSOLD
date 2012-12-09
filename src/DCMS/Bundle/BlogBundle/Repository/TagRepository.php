<?php

namespace DCMS\Bundle\BlogBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ODM\PHPCR\DocumentManager;

class TagRepository
{
    protected $em;
    protected $dm;

    public function __construct(EntityManager $em, DocumentManager $dm)
    {
        $this->em = $em;
        $this->dm = $dm;
    }

    public function getTagPostRepo()
    {
        return $this->em->getRepository('DCMS\Bundle\BlogBundle\Entity\Tag');
    }

    public function getPostRepo()
    {
        return $this->dm->getRepository('DCMS\Bundle\BlogBudle\Document\Post');
    }

    public function getWeightedTags()
    {
        $qb = $this->getTagPostRepo()->createQueryBuilder('tp');
        $qb->join('tp.tag', 't');
        $qb->select('t.name, count(tp.id)');
        $qb->group('t.name');
        $q = $this->getQuery();
        $q->execute();
    }
}
