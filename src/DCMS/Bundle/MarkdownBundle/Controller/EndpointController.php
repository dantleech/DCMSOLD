<?php

namespace DCMS\Bundle\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use dflydev\markdown\MarkdownParser;

class EndpointController extends Controller
{
    public function editAction($endpoint, $form)
    {
        return $this->render('DCMSMarkdownBundle:Endpoint:edit.html.twig', array(
            'endpoint' => $endpoint,
            'form' => $form,
        ));
    }

    public function renderAction($_endpoint)
    {
        $mdParser = new MarkdownParser;
        return $this->render('DCMSMarkdownBundle:Endpoint:render.html.twig', array(
            'endpoint' => $_endpoint,
            'markdown_parser' => $mdParser,
        ));
    }
}

