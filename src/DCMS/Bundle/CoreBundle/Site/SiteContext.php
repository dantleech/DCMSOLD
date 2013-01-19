<?php

namespace DCMS\Bundle\CoreBundle\Site;
use DCMS\Bundle\CoreBundle\Repository\SiteRepository;
use Symfony\Component\Routing\RequestContext;

class SiteContext
{
    protected $site;
    protected $sr;
    protected $siteName;

    protected $onEndpoint = false;

    public function __construct(SiteRepository $sr)
    {
        $this->sr = $sr;
    }

    public function setName($name)
    {
        $this->siteName = $name;
    }

    protected function init()
    {
        if ($this->site) {
            return;
        }

        if (!$this->siteName) {
            throw new \Exception('Cannot initialize site, don\'t know its name.');
        }

        $sitePath = '/sites/'.$this->siteName;

        $site = $this->sr->find($sitePath);

        if (!$site) {
            throw new Exception\SiteNotFoundException($sitePath);
        }

        $this->site = $site;
    }

    public function getSite()
    {
        $this->init();
        return $this->site;
    }

    public function hasSite()
    {
        return (boolean) $this->siteName;
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
