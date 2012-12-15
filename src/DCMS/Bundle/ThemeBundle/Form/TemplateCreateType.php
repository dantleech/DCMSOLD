<?php

namespace DCMS\Bundle\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use DCMS\Bundle\ThemeBundle\Document\Template;

class TemplateCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('resource');
        $builder->add('type', 'choice', array(
            'choices' => array(
                Template::TYPE_LAYOUT => 'Layout',
                Template::TYPE_PARTIAL => 'Partial',
                Template::TYPE_STYLESHEET => 'Stylesheet',
            )
        ));
    }

    public function getName()
    {
        return 'template_create';
    }
}

