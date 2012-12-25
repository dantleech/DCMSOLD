<?php

namespace DCMS\Bundle\BlogBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends DCMSController
{
    protected function getPostRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\Post');
    }

    protected function getBlogRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\BlogBundle\Document\BlogEndpoint');
    }
}
