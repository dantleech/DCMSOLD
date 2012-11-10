<?php

namespace DCMS\Bundle\AdminBundle\Controller;

class DanController
{
    public function getFoobar()
    {
        return $this->foobar;
    }
    
    public function setFoobar()
    {
        $this->foobar = $foobar;
    }
}
