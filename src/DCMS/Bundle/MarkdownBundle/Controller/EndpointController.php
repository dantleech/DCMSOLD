<?php

namespace DCMS\Bundle\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use dflydev\markdown\MarkdownParser;

class EndpointController extends Controller
{
    /**
     * @Route('/endpoint/markdown/_edit')
     * @Template()
     */
    public function editAction($endpoint, $form)
    {
        return array(
            'endpoint' => $endpoint,
            'form' => $form,
        );
    }

    /**
     * @Template()
     */
    public function renderAction($endpoint)
    {
        $mdParser = new MarkdownParser;
        return array(
            'endpoint' => $endpoint,
            'markdown_parser' => $mdParser,
        );
    }
}

