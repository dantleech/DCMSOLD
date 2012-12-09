<?php

namespace DCMS\Bundle\BlogBundle\Controller;
use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TagController extends DCMSController
{
    protected function getRepo()
    {
        return $this->get('dcms_blog.repository.tag');
    }

    /**
     * @Template
     */
    public function cloudAction()
    {
        $wTags = $this->getRepo()->getWeightedTags();

        return array(
            'wTags' => $wTags
        );
    }
}
