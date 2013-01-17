<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
use DCMS\Bundle\CoreBundle\Document\Endpoint;
use DCMS\Bundle\CoreBundle\Site\SiteContext;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class DCMSCoreExtension extends \Twig_Extension
{
    protected $nh;
    protected $sc;
    protected $mm;

    public function __construct(NotificationHelper $nh, SiteContext $sc, ModuleManager $mm)
    {
        $this->nh = $nh;
        $this->sc = $sc;
        $this->mm = $mm;
    }

    public function getGlobals()
    {
        return array(
            'dcms_notification_helper' => $this->nh,
            'site_context' => $this->sc,
        );
    }

    public function getFunctions()
    {
        return array(
            'ep_path' => new \Twig_Function_Method($this, 'epPath'),
            'ep_abs_path' => new \Twig_Function_Method($this, 'epAbsPath'),
            'ep_definition' => new \Twig_Function_Method($this, 'epDefinition'),
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

    public function epDefinition(Endpoint $endpoint)
    {
        return $this->mm->getEndpointDefinition($endpoint);
    }

    public function getName()
    {
        return 'dcms_core';
    }
}