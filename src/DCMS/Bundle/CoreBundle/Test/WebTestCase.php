<?php

namespace DCMS\Bundle\CoreBundle\Test;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    protected function getDm()
    {
        $dm = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');
        return $dm;
    }
}
