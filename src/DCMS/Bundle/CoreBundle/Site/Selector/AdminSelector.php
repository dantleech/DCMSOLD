<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;

/**
 * Class which can be told about a parameter in the URL
 * for the admin backoffice.
 *
 * e.g. /{site_name}/endpoints/list => /dantleech.com/endpoints/list => dantleech.com
 *
 * The DCMS router must tell this class about the parameter.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 * @date 13/01/21
 */
class AdminSelector extends AbstractHostSelector
{
    protected $siteName;

    public function setName($name)
    {
        $this->siteName = $name;
    }

    public function select()
    {
        if (null === $this->siteName) {
            throw new SiteNotFoundException('Site name not set');
        }

        $site = $this->repo->getByHost($this->siteName);

        if (!$site) {
            throw new SiteNotFoundException($this->siteName);
        }

        return $site;
    }
}
