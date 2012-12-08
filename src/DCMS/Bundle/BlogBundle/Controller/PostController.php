<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostController extends DCMSController
{
    protected function getRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\PostBundle\Document\Post');
    }

    /**
     * @Route("/post/{post_uuid}/edit")
     * @Template()
     */
    public function editAction($post_uuid)
    {
        return array(
        );
    }
}
