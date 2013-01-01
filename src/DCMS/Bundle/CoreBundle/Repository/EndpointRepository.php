<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use DCMS\Bundle\CoreBundle\Document\Site;

class EndpointRepository extends DocumentRepository
{
    public function getEndpointsForSelect(Site $site)
    {
    }
}
