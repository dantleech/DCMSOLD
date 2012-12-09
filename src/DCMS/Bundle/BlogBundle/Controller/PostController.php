<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PostController extends DCMSController
{
    protected function getRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
    }

    protected function getPost()
    {
        $post_uuid = $this->get('request')->get('post_uuid');
        if (!$post = $this->getRepo()->find($post_uuid)) {
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
            return $this->redirect($this->generateUrl('dcms_blog_blog_index', array(
            )));
        } catch (\Excposttion $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_blog_post_edit', array(
                'post_uuid' => $post->getUuid(),
            )));
        }
    }
}
