<?php

namespace DCMS\Bundle\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class CRUDController extends BaseController
{
    /**
     * @param string   $view
     * @param array    $parameters
     * @param Response $response
     *
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['admin']         = isset($parameters['admin']) ? $parameters['admin'] : $this->admin;
        $parameters['base_template'] = isset($parameters['base_template']) ? $parameters['base_template'] : $this->getBaseTemplate();
        $parameters['admin_pool']    = $this->get('dcms.admin.pool');

        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}
