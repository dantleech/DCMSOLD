<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

use DCMS\Bundle\CoreBundle\Repository\SiteRepository;

/**
 * Abstract class for host selectors
 *
 * @author Daniel Leech <daniel@dantleech.com>
 * @date 13/01/21
 */
class AbstractHostSelector
{
    protected $repo;

    public function __construct(SiteRepository $repo)
    {
        $this->repo = $repo;
    }
}
