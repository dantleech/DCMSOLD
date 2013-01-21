<?php

namespace DCMS\Bundle\ThemeBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use DCMS\Bundle\CoreBundle\Admin\DCMSSiteAdmin;
use DCMS\Bundle\ThemeBundle\Form\TemplateEditType;

class TemplateAdmin extends DCMSSiteAdmin
{
    public function getForm()
    {
        return $this->getFormContractor()->getFormFactory()->create(
            new TemplateEditType()
        );
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('resource', 'string', array('template' => 'DCMSThemeBundle:Admin:endpoint_path.html.twig'));
        $dm->add('title');
        $dm->add('updatedAt');
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}
