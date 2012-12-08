<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BlogController extends DCMSController
{
    protected function getRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\BlogEndpoint');
    }

    protected function getPostsRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
    }

    /**
     * @Route("/blog")
     * @Template()
     */
    public function indexAction()
    {
        $posts = $this->getPostsRepo()->findAll();

        return array(
            'posts' => $posts
        );
    }

    /**
     * @Template()
     */
    public function blogListAction()
    {
        $blogs = $this->getRepo()->findAll();
        return array(
            'blogs' => $blogs,
        );
    }
}
