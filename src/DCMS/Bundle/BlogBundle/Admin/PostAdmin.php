<?php

namespace DCMS\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use DCMS\Bundle\CoreBundle\Admin\DCMSAdmin;
use DCMS\Bundle\BlogBundle\Form\PostType;

/**
 * Description of BlogAdmin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostAdmin extends DCMSAdmin
{
    public function getForm()
    {
        return $this->getFormContractor()->getFormFactory()->create(
            new PostType()
        );
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('title');
        $dm->add('status');
        $dm->add('blog');
        $dm->add('updatedAt');
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}

?>
