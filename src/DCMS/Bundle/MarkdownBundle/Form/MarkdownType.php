<?php

namespace DCMS\Bundle\MarkdownBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form field for markdown with preview
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class MarkdownType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'preview' => false
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'dcms_markdown_textarea';
    }
}

?>