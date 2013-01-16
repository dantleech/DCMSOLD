<?php

namespace DCMS\Bundle\CoreBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;
use Doctrine\Common\Util\ClassUtils;

class DCMSAdmin extends Admin
{
    protected $documentOrganizer;

    public function setDocumentOrganizer(DocumentOrganizer $documentOrganizer)
    {
        $this->documentOrganizer = $documentOrganizer;
    }

    public function prePersist($object)
    {
        $dm = $this->getModelManager()->getDocumentManager();
        $meta = $dm->getClassMetadata(get_class($object));
        $refl = $meta->getReflectionClass();
        $prop = $refl->getProperty($meta->parentMapping);
        $prop->setAccessible(true);
        $parent = $prop->getValue($object);
        if (null === $parent) {
            $folder = $this->documentOrganizer->getDocumentFolder(ClassUtils::getClass($object));
            $prop->setValue($object, $folder);
        }

        parent::prePersist($object);
    }
}