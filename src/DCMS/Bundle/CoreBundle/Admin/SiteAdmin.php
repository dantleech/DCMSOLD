<?php

namespace DCMS\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class SiteAdmin extends DCMSAdmin
{
    protected function configureFormFields(FormMapper $fm)
    {
        $fm->add('name', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('name', 'string');
        $dm->add('homeEndpoint');
        $dm->add('_action', 'actions', array(
            'actions' => array(
                'dashboard' => array(
                    'template' => 'DCMSCoreBundle:Admin:site_dash_action.html.twig',
                )
            )
            
        ));
    }

    public function prePersist($object)
    {
        $parent = $this->getModelManager()->find(null, '/sites');
        $object->setParent($parent);
        parent::prePersist($object);
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('name')->assertNotBlank()->end();
    }
}
