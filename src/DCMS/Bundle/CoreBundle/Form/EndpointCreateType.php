<?php

namespace DCMS\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class EndpointCreateType extends AbstractType
{
    protected $mm;

    public function __construct(ModuleManager $mm)
    {
        $this->mm = $mm;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'DCMS\Bundle\AdminBundle\Model\EndpointCreateModel',
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nodeName');
        $builder->add('path');
        $builder->add('type', 'choice', array(
            'choices' => $this->mm->getEndpointsForSelect(),
        ));
    }

    public function getName()
    {
        return 'endpoint';
    }
}
