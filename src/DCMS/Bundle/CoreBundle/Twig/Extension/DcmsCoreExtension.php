<?php

namespace DCMS\Bundle\CoreBundle\Twig\Extension;

class DCMSCoreExtension extends \Twig_Extension
{
    private $mm;

    public function __construct(ModuleManager $mm)
    {
        $this->mm = $mm;
    }



    public function getName()
    {
        return 'dcms_core';
    }
}
