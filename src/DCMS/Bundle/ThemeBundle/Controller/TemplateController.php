<?php

namespace DCMS\Bundle\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DCMS\Bundle\ThemeBundle\Helper\TreeHelper;
use DCMS\Bundle\CoreBundle\Form\TemplateCreateType;
use DCMS\Bundle\CoreBundle\Document\Template as DocTemplate;

class TemplateController extends Controller
{
    protected function getRepo()
    {
        $repo = $this->get('dcms_core.repository.template');
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

    protected function getEPRoot()
    {
        $root = $this->getDm()->find(null, '/sites/dantleech/templates');
        return $root;
    }

    /**
     * @Route("/template")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}

