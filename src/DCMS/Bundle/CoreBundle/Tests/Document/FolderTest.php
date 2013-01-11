<?php

namespace DCMS\Bundle\CoreBundle\Tests\Document;

use DCMS\Bundle\CoreBundle\Document\Folder;

class FolderTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->folder = new Folder;
    }

    public function testGetChildren()
    {
        $this->folder->addChild(new \stdClass);
        $this->folder->addChild(new \stdClass);
        $this->folder->addChild(new Folder);
        $this->folder->getChildren();

        $this->assertCount(3, $this->folder->getChildren());

        $this->assertCount(1, $this->folder->getChildren('DCMS\Bundle\CoreBundle\Document\Folder'));
    }
}
