<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\RouteCollection;

class EndpointRepository extends DocumentRepository implements RouteRepositoryInterface

{
    public function findManyByUrl($url)
    {
        $ep = $this->findOneBy(array(
            'path' => $path,
        ));
        $collection = new RouteCollection(array($ep));

        return $collection;
    }
}
