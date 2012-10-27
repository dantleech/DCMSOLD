<?php

namespace DCMS\Bundle\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EndpointController extends Controller
{
    /**
     * @Template()
     */
    public function editAction($endpoint)
    {
        return array(
            'endpoint' => $endpoint,
        );
    }
}

