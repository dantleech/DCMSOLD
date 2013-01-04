<?php

namespace DCMS\Bundle\CoreBundle\Site;
use DCMS\Bundle\CoreBundle\Repository\SiteRepository;

class SiteContext
{
    protected $site;
    protected $sr;

    public function __construct(SiteRepository $sr)
    {
        $this->sr = $sr;
    }

    protected function init()
    {
        if ($this->site) {
            return;
        }

        $sitePath = '/sites/dantleech.com';
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

    public function getEndpointPath()
    {
        $this->init();
        return $this->site->getId().'/endpoints';
    }
}