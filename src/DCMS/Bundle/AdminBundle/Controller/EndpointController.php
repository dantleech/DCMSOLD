<?php

namespace DCMS\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DCMS\Bundle\AdminBundle\Helper\TreeHelper;
use DCMS\Bundle\CoreBundle\Form\EndpointCreateType;
use DCMS\Bundle\CoreBundle\Document\Endpoint;

class EndpointController extends Controller
{
    protected function getRepo()
    {
        $repo = $this->getDm()->getRepository('DCMS\Bundle\CoreBundle\Document\Endpoint');
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

    protected function getEndpoint()
    {
        $endpointUuid = $this->get('request')->get('endpoint_uuid');
        $ep = $this->getRepo()->find($endpointUuid);
        return $ep;
    }

    protected function getEPRoot()
    {
        $root = $this->getDm()->find(null, '/sites/dantleech.com/endpoints');
        return $root;
    }

    /**
     * @Template()
     */
    public function _treeAction()
    {
        $mm = $this->getMM();
        $root = $this->getEPRoot();

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
        $root = $this->getEPRoot();
        return array(
            'rootNode' => $root,
            'mm' => $this->getMm(),
        );
    }

    /**
     * @Route("/endpoint/edit/{endpoint_uuid}")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $ep = $this->getEndpoint();
        $epDef = $this->getMM()->getEndpointDefinition($ep);
        $formType = $epDef->getFormType('edit');
        $form = $this->createForm(new $formType, $ep);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getDm()->persist($ep);
                $this->getDm()->flush();
                $this->getNotifier()->info('Endpoint "%s" updated', array(
                    $ep->getTitle()
                ));

                return $this->redirect($this->generateUrl('dcms_admin_endpoint_edit', array(
                    'endpoint_uuid' => $ep->getUuid(),
                )));
            }
        }

        return array(
            'epDef' => $epDef,
            'ep' => $ep,
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
        } else {
            $parentEp = $this->getEPRoot();
        }

        $sourceEp->setParent($parentEp);

        if (isset($command['next']) && $nextUuid = $command['next']) {
            $nextEp = $this->getDm()->find(null, $nextUuid);
            $this->getDm()->reorder(
                $sourceEp->getParent(), 
                $sourceEp->getName(), 
                $nextEp->getName(), 
                true
            );
        }

        if (isset($command['prev']) && $prevUuid = $command['prev']) {
            $prevEp = $this->getDm()->find(null, $prevUuid);
            $this->getDm()->reorder(
                $sourceEp->getParent(), 
                $sourceEp->getName(), 
                $prevEp->getName(), 
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
                $ep->setTitle($data->title);
                $ep->setParent($parent);
                $ep->setPath($data->path);
                $this->getDm()->persist($ep);
                $this->getDm()->flush();
                $this->getDm()->refresh($ep);

                $this->getNotifier()->info('Endpoint "%s" created', array(
                    $ep->getTitle()
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

    /**
     * @Route("/endpoint/{endpoint_uuid}/delete")
     */
    public function deleteAction()
    {
        $ep = $this->getEndpoint();
        try {
            $this->getDm()->remove($ep);
            $this->getDm()->flush();
            $this->getNotifier()->info('Endpoint "%s" deleted', array(
                $ep->getId(),
            )); 
            return $this->redirect($this->generateUrl('dcms_admin_endpoint_index', array(
            )));
        } catch (\Exception $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_admin_endpoint_edit', array(
                'endpoint_uuid' => $ep->getUuid(),
            )));
        }
    }
}
