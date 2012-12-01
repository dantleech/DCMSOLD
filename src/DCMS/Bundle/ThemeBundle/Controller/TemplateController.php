<?php

namespace DCMS\Bundle\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DCMS\Bundle\ThemeBundle\Helper\TreeHelper;
use DCMS\Bundle\ThemeBundle\Document\Template as TemplateDocument;
use DCMS\Bundle\ThemeBundle\Form\TemplateEditType;
use DCMS\Bundle\ThemeBundle\Form\TemplateCreateType;

class TemplateController extends Controller
{
    protected function getRepo()
    {
        $repo = $this->get('dcms_theme.repository.template');
        return $repo;
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

    protected function getTemplate()
    {
        $templateUuid = $this->get('request')->get('template_uuid');
        $ep = $this->getRepo()->find($templateUuid);
        return $ep;
    }

    protected function getRootPath()
    {
        $root = $this->getDm()->find(null, '/sites/dantleech/templates');
        return $root;
    }

    /**
     * @Route("/templates")
     * @Route("/templates/{type}")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $type = $request->get('type');
        if (in_array($type, array('layout', 'partial'))) {
            $templates = $this->getRepo()->findBy(array('type' => $type));
        } else {
            $templates = $this->getRepo()->findAll();
        }
        return array(
            'templates' => $templates,
        );
    }

    /**
     * @Route("/template/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $template = new TemplateDocument;
        $form = $this->createForm(new TemplateCreateType(), $template);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $parent = $this->getRootPath();
                $template->setParent($parent);
                $this->getDm()->persist($template);
                $this->getDm()->flush();
                $this->getDm()->refresh($template);

                $this->getNotifier()->info('Template "%s" created', array(
                    $template->getTitle()
                ));

                return $this->render('DCMSThemeBundle:Template:createOK.html.twig', array(
                    'template' => $template,
                ));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/template/{template_uuid}/edit")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $template = $this->getTemplate();
        $form = $this->createForm(new TemplateEditType(), $template);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getDm()->persist($template);
                $this->getDm()->flush();
                $this->getNotifier()->info('Template "%s" updated', array(
                    $template->getTitle()
                ));

                return $this->redirect($this->generateUrl('dcms_theme_template_edit', array(
                    'template_uuid' => $template->getUuid(),
                )));
            }
        }

        return array(
            'template' => $template,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/template/{template_uuid}/delete")
     */
    public function deleteAction()
    {
        $template = $this->getTemplate();
        try {
            $this->getDm()->remove($template);
            $this->getDm()->flush();
            $this->getNotifier()->info('Template "%s" deleted', array(
                $template->getTitle(),
            )); 
            return $this->redirect($this->generateUrl('dcms_theme_template_index', array(
            )));
        } catch (\Exctemplatetion $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_theme_template_edit', array(
                'template_uuid' => $template->getUuid(),
            )));
        }
    }
}
