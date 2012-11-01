<?php

namespace DCMS\Bundle\CoreBundle\Tests\Helper;
use DCMS\Bundle\CoreBundle\Helper\ResponseHelper;

class ResponseHelperTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->rh = new ResponseHelper;
    }

    public function testCreateJsonResponse()
    {
        $resp = $this->rh->createJsonResponse(true, 'Foobar', $pl = array(
            'foobar' => 'barfoo',
        ));

        $expected = array(
            'success' => 'yes',
            'message' => 'Foobar',
            'payload' => $pl,
        );

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertEquals(json_encode($expected, true), $resp->getContent());
    }
}
