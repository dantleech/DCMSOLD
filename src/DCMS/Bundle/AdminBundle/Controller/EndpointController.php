<?php

namespace DCMS\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DCMS\Bundle\AdminBundle\Helper\TreeHelper;

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
     * @Route("/endpoint/edit/{endpoint_uuid}")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $endpointUuid = $request->get('endpoint_uuid');
        $ep = $this->getRepo()->find($endpointUuid);
        $epDef = $this->getMM()->getEndpointDefinition($ep);
        $formType = $epDef->getFormType('edit');
        $form = $this->createForm(new $formType, $ep);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getDm()->persist($ep);
                $this->getDm()->flush();
                return $this->redirect($this->generateUrl('dcms_admin_endpoint_edit', array(
                    'endpointId' => $ep->getId(),
                )));
            }
        }

        return array(
            'epDef' => $epDef,
            'endpoint' => $ep,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/endpoint/tree/update")
     * @Method("POST")
     */
    public function updateTreeAction(Request $request)
    {
        $commands = $request->get('commands');

        foreach ($commands as $command) {

            if (!$sourceEp = $this->getRepo()->find($command['source'])) {
                throw new \Exception('Could not find source node, uuid: '.$command['parent']);
            }

            if (isset($command['parent'])) {
                if (!$parentEp = $this->getRepo()->find($command['parent'])) {
                    throw new \Exception('Could not find parent node, uuid: '.$command['parent']);
                }

                $sourceEp->setParent($parentEp);
            }
        }

        $this->getDm()->flush();
        return $this->get('dcms_core.response_helper')->createJsonResponse(true);
    }
}
