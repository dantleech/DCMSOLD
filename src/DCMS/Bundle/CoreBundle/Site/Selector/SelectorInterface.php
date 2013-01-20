<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

/**
 * Interface for site selectors.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 * @date 13/01/20
 */
interface SelectorInterface
{
    /**
     * Select a site
     *
     * @return Site
     * @throws SiteNotFoundException
     */
    public function select();
}
