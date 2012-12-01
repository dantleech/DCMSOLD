<?php

namespace DCMS\Bundle\ThemeBundle\Template;

use DCMS\Bundle\CoreBundle\Site\SiteManager;
use DCMS\Bundle\ThemeBundle\Repository\TemplateRepository;
use DCMS\Bundle\CoreBundle\Document\Endpoint;

class TemplateManager
{
    protected $sm;
    protected $tr;

    public function __construct(SiteManager $sm, TemplateRepository $tr)
    {
        $this->sm = $sm;
        $this->tr = $tr;
    }

    public function getLayoutForEndpoint(Endpoint $endpoint)
    {
        $site = $this->sm->getSite();
        if ($layout = $endpoint->getLayout()) {
            return $layout->getResource();
        } else {
            $defaultLayoutUuid = $site->getPreference('dcms_theme.default_layout_uuid');
            if (!$defaultLayoutUuid) {
                throw new Exception\CannotFindDefaultLayoutForSite($site);
            }

            $defaultLayout = $this->tr->find($defaultLayoutUuid);
            if (!$defaultLayout) {
                throw new Exception\CannotFindDefaultLayoutForSite($site);
            }

            return $defaultLayout->getResource();
        }
    }
}
