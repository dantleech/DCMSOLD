<?php

namespace DCMS\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DCMSController extends Controller
{
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

    protected function getResponseHelper()
    {
        return $this->get('dcms_core.response_helper');
    }

    protected function getSite()
    {
        return $this->getSc()->getSite();
    }

    protected function getSc()
    {
        return $this->get('dcms_core.site.context');
    }
}
