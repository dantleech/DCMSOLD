<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends DCMSController
{
    protected function getRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\BlogEndpoint');
    }

    protected function getBlogRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\BlogEndpoint');
    }

    protected function getPostRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
    }

    /**
     * @Route("/blog")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $blog = null;
        $posts = $this->getPostRepo()->search(array(
            'tag' => $tag = $request->get('tag'),
            'blog_uuid' => $blogUuid = $request->get('blog_uuid'),
        ));

        if ($blogUuid) {
            $blog = $this->getBlogRepo()->find($blogUuid);
        }

        return array(
            'posts' => $posts,
            'tag' => $tag,
            'blog' => $blog,
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
