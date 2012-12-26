<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use dflydev\markdown\MarkdownParser;

class PostController extends BaseController
{
    protected function getPost()
    {
        $post_uuid = $this->get('request')->get('post_uuid');
        if (!$post = $this->getPostRepo()->find($post_uuid)) {
            throw $this->createHttpNotFoundException('Post with UUID "'.$uuid.'" not found.');
        }
        return $post;
    }

    protected function processForm($message, $form)
    {
        $post = $form->getData();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $parent = $post->getBlog();
                $post->setParent($parent);
                $this->getDm()->persist($post);
                $this->getDm()->flush();
                $this->getDm()->refresh($post);

                $this->getNotifier()->info($message, array(
                    $post->getTitle()
                ));

                return $this->redirect($this->generateUrl('dcms_blog_post_edit', array(
                    'post_uuid' => $post->getUuid(),
                )));
            }
        }
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
        $blogs = $this->getBlogRepo()->findAll();
        return array(
            'blogs' => $blogs,
        );
    }
    /**
     * @Route("/blog/post/{post_uuid}/edit")
     * @Template()
     */
    public function editAction($post_uuid)
    {
        $post = $this->getPost();
        $form = $this->createForm(new PostType, $post);
        if ($resp = $this->processForm('Post "%s" updated', $form)) {
            return $resp;
        }

        return array(
            'form' => $form->createView(),
            'post' => $post,
        );
    }

    /**
     * @Route("/blog/post/create")
     * @Template()
     */
    public function createAction()
    {
        $post = new Post;
        $form = $this->createForm(new PostType, $post);

        if ($resp = $this->processForm('Post "%s" created', $form)) {
            return $resp;
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/blog/post/{post_uuid}/delete")
     */
    public function deleteAction()
    {
        $post = $this->getPost();
        try {
            $this->getDm()->remove($post);
            $this->getDm()->flush();
            $this->getNotifier()->info('Post "%s" deleted', array(
                $post->getTitle(),
            )); 
            return $this->redirect($this->generateUrl('dcms_blog_post_index', array(
            )));
        } catch (\Excposttion $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_blog_post_edit', array(
                'post_uuid' => $post->getUuid(),
            )));
        }
    }

    /**
     * @Template()
     */
    public function renderAction()
    {
        $post = $this->get('request')->get('endpoint');
        $mdParser = new MarkdownParser;
        return array(
            'post' => $post,
            'markdown_parser' => $mdParser
        );
    }
}
