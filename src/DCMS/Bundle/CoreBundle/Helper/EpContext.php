<?php

namespace DCMS\Bundle\CoreBundle\Helper;

class EpContext
{
    protected $onEndpoint;

    public function setOnEndpoint($boilean)
    {
        $this->onEndpoint = $boilean;
    }

    public function getOnEndpoint()
    {
        return $this->onEndpoint;
    }

    public function onEndpoint()
    {
        return $this->getOnEndpoint();
    }

}
