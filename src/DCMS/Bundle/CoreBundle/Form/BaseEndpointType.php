<?php

namespace DCMS\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BaseEndpointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('layout', 'phpcr_document', array(
            'class' => 'DCMS\Bundle\ThemeBundle\Document\Template',
            'empty_value' => '<default template>',
            'empty_data' => '',
        ));
    }

    public function getName()
    {
        return 'endpoint';
    }
}
