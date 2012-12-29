<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use DCMS\Bundle\CoreBundle\Document\Endpoint;
use DCMS\Bundle\CoreBundle\Site\SiteManager;

class DCMSCoreExtension extends \Twig_Extension
{
    protected $nh;
    protected $sm;
    protected $epContext;

    public function __construct(NotificationHelper $nh, EpContext $epContext, SiteManager $sm)
    {
        $this->nh = $nh;
        $this->epContext = $epContext;
        $this->sm = $sm;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $environment->addGlobal('dcms_notification_helper', $this->nh);
        $environment->addGlobal('ep', $this->epContext);
        $environment->addGlobal('site_manager', $this->sm);
    }

    public function getFunctions()
    {
        return array(
            'ep_path' => new \Twig_Function_Method($this, 'epPath'),
            'ep_abs_path' => new \Twig_Function_Method($this, 'epAbsPath')
        );
    }

    public function epPath(Endpoint $endpoint)
    {
        $epPath = $this->sm->getEndpointPath();
        return substr($endpoint->getId(), strlen($epPath));
    }

    public function epAbsPath(Endpoint $endpoint)
    {
        return sprintf('http://%s%s',
            $this->sm->getSite()->getName(),
            $this->epPath($endpoint)
        );
    }

    public function getName()
    {
        return 'dcms_core';
    }
}
