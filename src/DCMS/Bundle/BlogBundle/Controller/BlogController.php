<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use dflydev\markdown\MarkdownParser;

class BlogController extends DCMSController
{
    /**
     * @Template()
     */
    public function renderAction()
    {
        $blog = $this->get('request')->get('endpoint');
        return array(
            'blog' => $blog,
        );
    }
}
