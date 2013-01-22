<?php

namespace DCMS\Bundle\CoreBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Doctrine\Common\Util\ClassUtils;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class DCMSSiteAdmin extends DCMSAdmin
{
    public function getBaseRoutePattern()
    {
        $parts = explode('\\', $this->getClass());
        return strtolower(array_pop($parts));
    }

    public function __construct($code, $class, $baseControllerName = null)
    {
        $baseControllerName = 'DCMSCoreBundle:CRUD';
        parent::__construct($code, $class, $baseControllerName);
    }


    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere($query->expr()->descendant($this->siteContext->getSite()->getId()));

        return $query;
    }

    public function getTemplate($name)
    {
        if ($name == 'layout') {
            return 'DCMSCoreBundle:Admin:layout.html.twig';
        }

        return parent::getTemplate($name);
    }
}
