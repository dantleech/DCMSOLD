<?php

namespace DCMS\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EndpointController extends Controller
{
    /**
     * @Route("/endpoint/menu/_edit")
     * @Template()
     */
    public function editAction()
    {
        return array();
    }
}
