<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends BaseController
{
    /**
     * @Template()
     */
    public function renderAction(Request $request)
    {
        $blog = $this->get('request')->get('_endpoint');
        $posts = $this->getPostRepo()->search(array(
            'tag' => $tag = $request->get('tag'),
            'blog_uuid' => $blog->getUuid(),
        ));
        return array(
            'blog' => $blog,
            'posts' => $posts,
            'tag' => $tag
        );
    }
}
