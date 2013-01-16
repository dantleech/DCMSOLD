<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site;
use DCMS\Bundle\CoreBundle\Site\DocumentOrganizer;

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
        $this->sc->expects($this->any())
            ->method('getSite')
            ->will($this->returnValue($this->site));
        $this->dm->expects($this->once())
            ->method('persist');

        $this->do->documentsOfClass('stdClass')
            ->belongInFolder('standardClasses');
        $this->do->getDocumentFolder('stdClass');
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\FolderDoesNotExist
     */
    public function testGetDocumentFolder_notExists_noCreate()
    {
        $this->sc->expects($this->any())
            ->method('getSite')
            ->will($this->returnValue($this->site));

        $this->do->documentsOfClass('stdClass')
            ->belongInFolder('standardClasses');
        $this->do->getDocumentFolder('stdClass', false);
    }
}
