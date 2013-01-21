<?php

namespace DCMS\Bundle\CoreBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class SiteRepository extends DocumentRepository
{
    public function getByHost($host)
    {
        $site = $this->dm->find('DCMS\Bundle\CoreBundle\Document\Site', 'sites/'.$host);

        return $site;
    }
}

