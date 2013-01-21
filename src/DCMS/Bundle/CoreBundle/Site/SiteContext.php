<?php

namespace DCMS\Bundle\CoreBundle\Site;
use DCMS\Bundle\CoreBundle\Repository\SiteRepository;
use Symfony\Component\Routing\RequestContext;
use DCMS\Bundle\CoreBundle\Site\Selector\SelectorInterface;
use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;

class SiteContext
{
    protected $site;
    protected $siteName;
    protected $siteSelector;

    protected $onEndpoint = false;

    public function __construct(SelectorInterface $siteSelector)
    {
        $this->siteSelector = $siteSelector;
    }

    protected function init()
    {
        if ($this->site) {
            return;
        }

        $this->site = $this->siteSelector->select();
    }

    public function getSite()
    {
        $this->init();
        return $this->site;
    }

    public function hasSite()
    {
        try {
            $this->init();
        } catch (SiteNotFoundException $e) {
        }

        return (boolean) $this->site;
    }

    public function getEndpointPath()
    {
        $this->init();
        return $this->site->getId().'/endpoints';
    }

    public function getAssetsUrl()
    {
        $this->init();
        return '/media'.$this->site->getId();
    }

    /**
     * Return true if we are on an endpoint
     * (i.e. we are on the frontend)
     *
     * @return boolean
     */
    public function getOnEndpoint()
    {
        return $this->onEndpoint;
    }

    public function setOnEndpoint($boolean)
    {
        $this->onEndpoint = $boolean;
    }
}
