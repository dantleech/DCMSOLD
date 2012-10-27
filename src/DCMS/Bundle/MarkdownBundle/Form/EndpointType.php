<?php

namespace DCMS\Bundle\MarkdownBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use DCMS\Bundle\RoutingBundle\Form\BaseEndpointType;

class EndpointType extends BaseEndpointType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('content', 'textarea');
    }
}
