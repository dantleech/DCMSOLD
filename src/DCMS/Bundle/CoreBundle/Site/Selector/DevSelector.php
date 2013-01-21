<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;
use DCMS\Bundle\CoreBundle\Repository\SiteRepository;

/**
 * Site selector for development mode
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class DevSelector extends AbstractHostSelector
{
    protected $repo;

    public function select()
    {
        if (isset($_GET['_site'])) {
            $siteName = $_GET['_site'];
        } else {
            throw new SiteNotFoundException('[DEV SELECTOR] Could not find _site parameter in $_GET, bailing out.');
        }

        $site = $this->repo->findByHost($siteName);

        if (null === $site) {
            throw new SiteNotFoundException('Cannot find site with host "'.$siteName.'"');
        }

        return $site;
    }
}
