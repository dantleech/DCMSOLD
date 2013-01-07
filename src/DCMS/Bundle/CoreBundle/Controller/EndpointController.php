<?php

namespace DCMS\Bundle\CoreBundle\Controller;
use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EndpointController extends DCMSController
{
    /**
     * @Template
     */
    public function defaultAction($_endpoint)
    {
        return array('endpoint' => $_endpoint);
    }
}
