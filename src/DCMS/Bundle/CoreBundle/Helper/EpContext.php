<?php

namespace DCMS\Bundle\CoreBundle\Helper;

class EpContext
{
    protected $inEndpoint;

    public function setInEndpoint($boolean)
    {
        $this->inEndpoint = $boolean;
    }

    public function getInEndpoint()
    {
        return $this->inEndpoint;
    }
}
