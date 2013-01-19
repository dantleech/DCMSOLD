<?php

namespace DCMS\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @return string
     */
    public function getBaseTemplate()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->container->get('dcms.admin.pool')->getTemplate('ajax');
        }

        return $this->container->get('dcms.admin.pool')->getTemplate('layout');
    }

    /**
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render($this->container->get('dcms.admin.pool')->getTemplate('dashboard'), array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('dcms.admin.pool'),
            'blocks'          => array(),
        ));
    }
}