<?php

namespace DCMS\Bundle\MarkdownBundle\Admin;
use DCMS\Bundle\CoreBundle\Admin\DCMSSiteAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use DCMS\Bundle\MarkdownBundle\Form\EndpointType;


/**
 * Description of MarkdownAdmin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class MarkdownAdmin extends DCMSSiteAdmin
{
    public function getForm()
    {
        return $this->getFormContractor()->getFormFactory()->create(
            new EndpointType()
        );
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('id', 'string', array('template' => 'DCMSCoreBundle:Admin:endpoint_path.html.twig'));
        $dm->add('title');
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}

?>
