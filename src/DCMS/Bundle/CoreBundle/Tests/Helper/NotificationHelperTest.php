<?php

namespace DCMS\Bundle\CoreBundle\Tests\Helper;
use DCMS\Bundle\CoreBundle\Helper\NotificationHelper;

class NotificationHelperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->sess = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');
        $this->nm = new NotificationHelper($this->sess);
    }

    public function test()
    {
        $this->nm->info('Foobar OK 1');
        $this->nm->info('Foobar OK 2');
        $this->nm->error('Foobar Foobarred');

        $this->assertEquals(2, count($this->nm->getInfos()));
        $this->assertEquals(1, count($this->nm->getErrors()));
    }
}
