<?php

namespace DCMS\Bundle\CoreBundle\Admin;
use Sonata\AdminBundle\Admin\Pool as BasePool;

class Pool extends BasePool
{
    public function getTemplate($name)
    {
        if ($name == 'dashboard') {
            return 'DCMSCoreBundle:Admin:site_dashboard.html.twig';
        }

        return parent::getTemplate($name);
    }
}