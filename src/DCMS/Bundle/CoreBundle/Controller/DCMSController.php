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

    protected function getSite()
    {
        return $this->getSm()->getSite();
    }

    protected function getSm()
    {
        return $this->get('dcms_core.site_manager');
    }
}
