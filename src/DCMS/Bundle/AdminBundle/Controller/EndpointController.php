<?php

namespace DCMS\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EndpointController extends Controller
{
    protected function getRepo()
    {
        $repo = $this->get('dcms_routing.repository.endpoint');
        return $repo;
    }

    protected function getMM()
    {
        $mm = $this->get('dcms_core.module_manager');
        return $mm;
    }

    protected function getDm()
    {
        $dm = $this->get('doctrine_phpcr.odm.default_document_manager');
        return $dm;
    }

    /**
     * @Template()
     */
    public function _treeAction()
    {
        $root = $this->getDm()->find(null, '/');
        $mm = $this->getMM();

        return array(
            'mm' => $mm,
            'root' => $root,
        );
    }

    /**
     * @Route("/endpoint")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *  "/endpoint/edit/{endpointId}",
     *  requirements={"endpointId"=".+"}
     * )
     * @Template()
     */
    public function editAction($endpointId)
    {
        $ep = $this->getRepo()->find($endpointId);
        $epDef = $this->getMM()->getEndpointDefinition($ep);

        return array(
            'epDef' => $epDef,
            'endpoint' => $ep,
        );
    }
}
