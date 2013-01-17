<?php

namespace DCMS\Bundle\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use DCMS\Bundle\ThemeBundle\Document\Template;

class TemplateEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('resource');
        $builder->add('source', 'textarea');
    }

    public function getName()
    {
        return 'template_edit';
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['data_class'] = 'DCMS\Bundle\ThemeBundle\Document\Template';
        return $options;
    }
}
