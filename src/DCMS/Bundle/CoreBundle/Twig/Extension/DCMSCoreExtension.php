<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use DCMS\Bundle\CoreBundle\Document\Endpoint;

class DCMSCoreExtension extends \Twig_Extension
{
    protected $nh;
    protected $epContext;

    public function __construct(NotificationHelper $nh, EpContext $epContext)
    {
        $this->nh = $nh;
        $this->epContext = $epContext;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $environment->addGlobal('dcms_notification_helper', $this->nh);
        $environment->addGlobal('ep', $this->epContext);
    }

    public function getFunctions()
    {
        return array(
            'ep_path' => new \Twig_Function_Method($this, 'epPath')
        );
    }

    public function epPath(Endpoint $endpoint)
    {
        return $endpoint->getFullPath();
    }

    public function getName()
    {
        return 'dcms_core';
    }
}
