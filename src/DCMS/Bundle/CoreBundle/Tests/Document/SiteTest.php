<?php

namespace DCMS\Bundle\CoreBundle\Tests\Document;

use DCMS\Bundle\CoreBundle\Document\Site;

class SiteTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->site = new Site;
    }

    public function testPreferences()
    {
        $this->site->setPreference('hello', 'daniel');
        $this->site->setPreference('goodbye', 'leech');
        $this->assertEquals('daniel', $this->site->getPreference('hello'));
        $this->assertEquals('leech', $this->site->getPreference('goodbye'));
    }
}
