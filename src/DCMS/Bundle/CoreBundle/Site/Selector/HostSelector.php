<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\AbstractHostSelector;
use Symfony\Component\Routing\RequestContext;
use DCMS\Bundle\CoreBundle\Repository\SiteRepository;
use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;

/**
 * Select a site based on the host name
 *
 * NOTE: That at the moment, site name = host name. This isn't the
 *       best solution (a website could have multiple domains / sub domains)
 *       but for now, ça va.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 * @date 13/01/21
 */
class HostSelector extends AbstractHostSelector
{
    protected $requestContext;

    public function __construct(SiteRepository $repo, RequestContext $requestContext)
    {
        $this->repo = $repo;
        $this->requestContext = $requestContext;
    }

    public function select()
    {
        $siteName = $this->requestContext->getHost();
        $site = $this->repo->findByHost($siteName);

        if (null === $site) {
            throw new SiteNotFoundException('Cannot find site with host "'.$siteName.'"');
        }

        return $site;
    }
}
