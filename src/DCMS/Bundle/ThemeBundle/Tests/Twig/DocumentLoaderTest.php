<?php

namespace DCMS\Bundle\ThemeBundle\Tests\Twig;
use DCMS\Bundle\ThemeBundle\Twig\DocumentLoader;

class DocumentLoaderTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->repo = $this->getMockBuilder('DCMS\Bundle\ThemeBundle\Repository\TemplateRepositoryInterface')
          ->disableOriginalConstructor()
          ->getMock();
        $this->template = $this->getMockBuilder('DCMS\Bundle\ThemeBundle\Document\Template')
          ->disableOriginalConstructor()
          ->getMock();
        $this->tl = new DocumentLoader($this->repo);
    }

    protected function initGetTemplate($callCount = 1)
    {
        $this->repo->expects($this->once())
            ->method('findTemplate')
            ->with('test')
            ->will($this->returnValue($this->template));

        $this->template->expects($this->exactly($callCount))
            ->method('getSource')
            ->will($this->returnValue('foobar'));

    }

    public function testGetSource()
    {
        $this->initGetTemplate(2);
        $res = $this->tl->getSource('test');
        $this->assertEquals('foobar', $res);

        // test cache
        $res = $this->tl->getSource('test');
        $this->assertEquals('foobar', $res);
    }

    public function testGetSourceNull()
    {
        $this->repo->expects($this->once())
            ->method('findTemplate')
            ->with('test')
            ->will($this->returnValue(null));
        $this->assertNull($this->tl->getSource('test'));
    }

    public function testGetCacheKey()
    {
        $this->initGetTemplate(1);
        $id = $this->tl->getCacheKey('test');
        $this->assertEquals('test', $id);
    }

    public function testGetCacheKeyNull()
    {
        $this->repo->expects($this->once())
            ->method('findTemplate')
            ->with('test')
            ->will($this->returnValue(null));
        $this->assertNull($this->tl->getCacheKey('test'));
    }

    public function testIsFresh_fresh()
    {
        $this->initGetTemplate(0);
        $ts = 1354352565;
        $templateDate = new \DateTime();
        $templateDate->setTimestamp($ts - 100);
        $this->template->expects($this->once())
            ->method('getUpdatedAt')
            ->will($this->returnValue($templateDate));

        $this->assertTrue($this->tl->isFresh('test', $ts));
    }

    public function testIsFresh_notFresh()
    {
        $this->initGetTemplate(0);
        $ts = 1354352565;
        $templateDate = new \DateTime();
        $templateDate->setTimestamp($ts + 100);
        $this->template->expects($this->once())
            ->method('getUpdatedAt')
            ->will($this->returnValue($templateDate));

        $this->assertFalse($this->tl->isFresh('test', $ts));
    }
}
