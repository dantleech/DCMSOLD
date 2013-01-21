<?php

namespace DCMS\Bundle\CoreBundle\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\SelectorInterface;
use Psr\Log\LoggerInterface;
use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;

/**
 * Description here
 *
 * @author Daniel Leech <daniel@dantleech.com>
 * @date 13/01/21
 */
class ChainSelector implements SelectorInterface
{
    protected $selectors = array();
    protected $logger;

    public function __construct($selectors = array(), LoggerInterface $logger)
    {
        $this->selectors = $selectors;
        $this->logger = $logger;
    }

    public function addSelector(SelectorInterface $selector)
    {
        $this->selectors[] = $selector;
    }

    /**
     * Try multiple selectors until one succeeds
     */
    public function select()
    {
        $site = null;

        foreach ($this->selectors as $selector) {
            try {
                $site = $selector->select();

                if (null !== $this->logger) {
                    $this->logger->info(sprintf('Site selector "%s" found site "%s"', 
                        get_class($selector),
                        $site ? $site->getName() : 'selector returned null'
                    ));
                }

                if (null !== $site) {
                    break;
                }

            } catch (SiteNotFoundException $e) {
                if (null !== $this->logger) {
                    $this->logger->warning(sprintf('Site selector "%s" failed: %s', 
                        get_class($selector),
                        $e->getMessage()
                    ));
                }
            }

            continue;
        }

        if (!$site) {
            throw new SiteNotFoundException('None of the chained site selectors found a site.');
        }

        return $site;
    }
}
