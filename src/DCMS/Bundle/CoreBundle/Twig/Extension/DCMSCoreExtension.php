<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;

class DCMSCoreExtension extends \Twig_Extension
{
    public function __construct(NotificationHelper $nh)
    {
        $this->nh = $nh;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $environment->addGlobal('dcms_notification_helper', $this->nh);
    }

    public function getName()
    {
        return 'dcms_core';
    }
}
