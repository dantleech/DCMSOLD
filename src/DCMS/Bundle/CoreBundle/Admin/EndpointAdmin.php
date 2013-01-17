<?php

namespace DCMS\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class EndpointAdmin extends DCMSAdmin
{
    public function configure()
    {
        $epsForSelect = $this->moduleManager->getEndpointsForSelect();
        $epsForSelect = array_flip($epsForSelect);
        $this->setSubClasses($epsForSelect);

        $this->setTemplate('edit', 'DCMSCoreBundle:Admin:endpoint_layout.html.twig');
    }

    public function getForm()
    {
        $epDef = $this->moduleManager->getEndpointDefinition($this->getSubject());
        $formType = $epDef->getFormType('edit');
        $form = $this->getFormContractor()->getFormFactory()->create(
            new $formType, $this->getSubject()
        );
        return $form;
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('id', 'string', array('template' => 'DCMSCoreBundle:Admin:endpoint_path.html.twig'));
        $dm->add('title');
        $dm->add('type');
        $dm->add('status');
        $dm->add('layout');
        $dm->add('updatedAt');
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}