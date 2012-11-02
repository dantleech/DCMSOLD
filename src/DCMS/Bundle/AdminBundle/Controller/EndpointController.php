<?php

namespace DCMS\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DCMS\Bundle\AdminBundle\Helper\TreeHelper;
use DCMS\Bundle\RoutingBundle\Form\EndpointCreateType;
use DCMS\Bundle\RoutingBundle\Document\Endpoint;

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

    protected function getNotifier()
    {
        $notifier = $this->get('dcms_core.notification_helper');
        return $notifier;
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
                $this->getNotifier()->info('Endpoint "%s" updated', array(
                    $ep->getNodeName()
                ));

                return $this->redirect($this->generateUrl('dcms_admin_endpoint_edit', array(
                    'endpoint_uuid' => $ep->getUuid(),
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
     * @Route("/endpoint/tree/update", defaults={"_format"="json"})
     * @Method("POST")
     */
    public function updateTreeAction(Request $request)
    {
        $command = $request->get('command', array());

        $sourceEp = $this->getDm()->find(null, $command['source']);

        if (isset($command['parent'])) {
            $parentEp = $this->getDm()->find(null, $command['parent']);
            $sourceEp->setParent($parentEp);
        }

        if (isset($command['next']) && $nextUuid = $command['next']) {
            $nextEp = $this->getDm()->find(null, $nextUuid);
            $this->getDm()->reorder(
                $sourceEp->getParent(), 
                $sourceEp->getNodeName(), 
                $nextEp->getNodeName(), 
                true
            );
        }

        if (isset($command['prev']) && $prevUuid = $command['prev']) {
            $prevEp = $this->getDm()->find(null, $prevUuid);
            $this->getDm()->reorder(
                $sourceEp->getParent(), 
                $sourceEp->getNodeName(), 
                $prevEp->getNodeName(), 
                false
            );
        }

        $this->getDm()->flush();

        return $this->get('dcms_core.response_helper')->createJsonResponse(true);
    }

    /**
     * @Route("/endpoint/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new EndpointCreateType(
            $this->getMM()
        ));

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $epClass = $data->type;
                $parent = $this->getDm()->find(null, '/');

                $ep = new $epClass;
                $ep->setNodeName($data->path);
                $ep->setParent($parent);
                $ep->setPath($data->path);
                $this->getDm()->persist($ep);
                $this->getDm()->flush();
                $this->getDm()->refresh($ep);

                $this->getNotifier()->info('Endpoint "%s" created', array(
                    $ep->getNodeName()
                ));

                return $this->render('DCMSAdminBundle:Endpoint:createOK.html.twig', array(
                    'ep' => $ep,
                ));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
