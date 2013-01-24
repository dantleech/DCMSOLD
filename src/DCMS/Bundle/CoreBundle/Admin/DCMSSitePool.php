<?php

namespace DCMS\Bundle\CoreBundle\Admin;
use Sonata\AdminBundle\Admin\Pool as BasePool;

class DCMSSitePool extends BasePool
{
    public function getTemplate($name)
    {
        if ($name == 'dashboard') {
            return 'DCMSCoreBundle:Admin:site_dashboard.html.twig';
        }

        if ($name == 'layout') {
            return 'DCMSCoreBundle:Admin:site_admin_layout.html.twig';
        }

        return parent::getTemplate($name);
    }
}
