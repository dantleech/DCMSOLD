<?php

namespace DCMS\Bundle\CoreBundle\Tests\Organizer;
use DCMS\Bundle\CoreBundle\Organizer\DocumentOrganizer;

class DocumentOrganizerTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->sc = $this->getMockBuilder('DCMS\Bundle\CoreBundle\Site\SiteContext')
          ->disableOriginalConstructor()
          ->getMock();
        $this->dm = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')
          ->disableOriginalConstructor()
          ->getMock();
        $this->site = $this->getMock('DCMS\Bundle\CoreBundle\Document\Site');
        $this->do = new DocumentOrganizer($this->sc, $this->dm);
    }

    public function testGetDocumentFolder_notExists()
    {
        $this->dm->expects($this->once())
            ->method('persist');
        $this->dm->expects($this->at(0))
            ->method('find')
            ->with(null, '/standard');
        $this->dm->expects($this->at(1))
            ->method('find')
            ->with(null, '/');

        $this->do->register('stdClass', '/standard');
        $folder = $this->do->getDocumentFolder('stdClass');
        $this->assertEquals('standard', $folder->getNodeName());
    }

    public function testGetDocumentFolder_notExists_site()
    {
        $this->dm->expects($this->once())
            ->method('persist');
        $this->dm->expects($this->at(0))
            ->method('find')
            ->with(null, '/sites/foo.com/standard');
        $this->dm->expects($this->at(1))
            ->method('find')
            ->with(null, '/sites/foo.com');
        $this->sc->expects($this->once())
            ->method('getSite')
            ->will($this->returnValue($this->site));
        $this->site->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('/sites/foo.com'));

        $this->do->register('stdClass', '@site:/standard');
        $folder = $this->do->getDocumentFolder('stdClass');
        $this->assertEquals('standard', $folder->getNodeName());
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Organizer\FolderDoesNotExist
     */
    public function testGetDocumentFolder_notExists_noCreate()
    {
        $this->do->register('stdClass', '/standard');
        $this->do->getDocumentFolder('stdClass', false);
    }
}
