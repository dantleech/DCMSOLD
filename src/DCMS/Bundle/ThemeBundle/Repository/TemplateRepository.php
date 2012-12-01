<?php

namespace DCMS\Bundle\ThemeBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class TemplateRepository extends DocumentRepository implements TemplateRepositoryInterface
{
    public function findTemplate($id)
    {
        return $this->findOneBy(array(
            'resource' => $id,
        ));
    }
}
