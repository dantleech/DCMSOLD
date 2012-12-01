<?php

namespace DCMS\Bundle\ThemeBundle\Twig\Extension;

use DCMS\Bundle\ThemeBundle\Template\TemplateManager;

class ThemeExtension extends \Twig_Extension
{
    protected $tm;

    public function __construct(TemplateManager $tm)
    {
        $this->tm = $tm;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $environment->addGlobal('template_manager', $this->tm);
    }

    public function getName()
    {
        return "dcms_theme";
    }
}
