<?php

namespace DCMS\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EndpointController extends Controller
{
    /**
     * @Route("/endpoint")
     * @Template()
     */
    public function indexAction()
    {
        $mm = $this->get('dcms_core.module_manager');
        $repo = $this->get('dcms_routing.repository.endpoint');
        $root = $repo->find(null, '/');

        return array(
            'mm' => $mm,
            'root' => $root,
        );
    }
}
