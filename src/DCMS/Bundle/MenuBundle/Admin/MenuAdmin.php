<?php

namespace DCMS\Bundle\MenuBundle\Admin;

use DCMS\Bundle\CoreBundle\Admin\DCMSAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class MenuAdmin extends DCMSAdmin
{
    protected function configureFormFields(FormMapper $fm)
    {
        $fm->add('title', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('id', 'text');
        $dm->add('title');
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}