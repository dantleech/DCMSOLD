<?php

namespace DCMS\Bundle\CoreBundle\Tests\Helper;
use DCMS\Bundle\CoreBundle\Helper\EpContext;
;
class EpContextTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->epContext = new EpContext;
    }

    public function testSetGetInEndpoint()
    {
        $this->epContext->setInEndpoint(true);
        $this->assertTrue($this->epContext->getInEndpoint());
    }
}

