<?php

namespace DCMS\Bundle\CoreBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use DCMS\Bundle\CoreBundle\Organizer\DocumentOrganizer;
use Doctrine\Common\Util\ClassUtils;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;
use DCMS\Bundle\CoreBundle\Site\SiteContext;

class DCMSAdmin extends Admin
{
    protected $documentOrganizer;
    protected $moduleManager;
    protected $siteContext;

    public function getBaseRoutePattern()
    {
        $parts = explode('\\', $this->getClass());
        return strtolower(array_pop($parts));
    }

    public function setDocumentOrganizer(DocumentOrganizer $documentOrganizer)
    {
        $this->documentOrganizer = $documentOrganizer;
    }

    public function setModuleManager(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function setSiteContext(SiteContext $siteContext)
    {
        $this->siteContext = $siteContext;
    }

    public function prePersist($object)
    {
        $folder = $this->documentOrganizer->fileDocument($object);

        parent::prePersist($object);
    }
}
