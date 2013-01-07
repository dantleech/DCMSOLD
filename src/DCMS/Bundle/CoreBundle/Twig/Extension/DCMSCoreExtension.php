<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use DCMS\Bundle\CoreBundle\Document\Endpoint;
use DCMS\Bundle\CoreBundle\Site\SiteContext;

class DCMSCoreExtension extends \Twig_Extension
{
    protected $nh;
    protected $sm;
    protected $epContext;

    public function __construct(NotificationHelper $nh, EpContext $epContext, SiteContext $sm)
    {
        $this->nh = $nh;
        $this->epContext = $epContext;
        $this->sc = $sm;
    }

    public function getGlobals()
    {
        return array(
            'dcms_notification_helper' => $this->nh,
            'ep' => $this->epContext,
            'site_context' => $this->sc,
        );
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
        $epPath = $this->sc->getEndpointPath();
        return substr($endpoint->getId(), strlen($epPath));
    }

    public function epAbsPath(Endpoint $endpoint)
    {
        return sprintf('http://%s%s',
            $this->sc->getSite()->getName(),
            $this->epPath($endpoint)
        );
    }

    public function getName()
    {
        return 'dcms_core';
    }
}
