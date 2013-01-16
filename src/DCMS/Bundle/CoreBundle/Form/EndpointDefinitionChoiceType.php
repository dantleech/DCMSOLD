<?php

namespace DCMS\Bundle\CoreBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use DCMS\Bundle\CoreBundle\Module\ModuleManager;

class EndpointDefinitionChoiceType extends ChoiceType
{
    protected $mm;

    public function __construct(ModuleManager $mm)
    {
        $this->mm = $mm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = array_merge(
            $options, array(
                'choices' => $this->mm->getEndpointsForSelect()
            )
        );
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'dcms_endpoint_definition_choice';
    }
}
