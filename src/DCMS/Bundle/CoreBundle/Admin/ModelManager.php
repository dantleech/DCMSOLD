<?php

namespace DCMS\Bundle\CoreBundle\Admin;
use Sonata\DoctrinePHPCRAdminBundle\Model\ModelManager as BaseModelManager;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ODM\PHPCR\DocumentManager;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;

class ModelManager extends BaseModelManager
{
    protected $dm;
    protected $do;

    public function __construct(DocumentManager $documentManager, DocumentOrganizer $do)
    {
        $this->dm = $dm;
        $this->do = $do;
    }

    public function create($object)
    {
        $meta = $this->dm->getClassMetadata(ClassUtils::getClass($object));
        $prop = $meta->getReflectionProperty($meta->parentMapping);
        $parent = $prop->getValue($object);

        if (!$parent) {
            $folder = $this->do->getDocumentFolder($object);
            $prop->setValue($object, $folder);
        }

        return parent::create($object);
    }
}
