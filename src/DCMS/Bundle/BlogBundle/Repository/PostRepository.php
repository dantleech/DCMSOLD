<?php

namespace DCMS\Bundle\BlogBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;

class PostRepository extends DocumentRepository
{ 
    public function search($options)
    {
        $options = array_merge(array(
            'tag' => null,
            'blog_uuid' => null,
        ), $options);
        $qb = $this->createQueryBuilder('p');
        $qf = $qb->getQOMFactory();

        $criterias = array();
        if ($options['tag']) {
            $criterias[] = $qf->comparison(
                $qf->propertyValue('tags'), 
                Constants::JCR_OPERATOR_EQUAL_TO,
                $qf->literal($options['tag'])
            );
        }

        if ($options['blog_uuid']) {
            $criterias[] = $qf->comparison(
                $qf->propertyValue('blog'),
                Constants::JCR_OPERATOR_EQUAL_TO,
                $qf->literal($options['blog_uuid'])
            );
        }

        if (count($criterias) == 2) {
            $qb->where($qf->and($criterias[0], $criterias[1]));
        } elseif (count($criterias) == 1) {
            $qb->where(current($criterias));
        }

        $qb->orderBy($qf->propertyValue('date'), 'DESC');
        $q = $qb->getQuery();

        $res = $this->getDocumentsByQuery($q);
        return $res;
    }
}
