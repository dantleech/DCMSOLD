<?php

namespace DCMS\Bundle\CoreBundle\Tests\Site\Selector;

use DCMS\Bundle\CoreBundle\Site\Selector\ChainSelector;
use DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException;

class ChainSelectorTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->selector1 = $this->getMock('DCMS\Bundle\CoreBundle\Site\Selector\SelectorInterface');
        $this->selector2 = $this->getMock('DCMS\Bundle\CoreBundle\Site\Selector\SelectorInterface');
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->site = $this->getMock('DCMS\Bundle\CoreBundle\Document\Site');
        $this->site->expects($this->any())
            ->method('getName');
        $this->chainSelect = new ChainSelector(array(
            $this->selector1,
        ), $this->logger);
        $this->chainSelect->addSelector($this->selector2); // test add selector
    }

    /**
     * @expectedException DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException
     */
    public function testAllReturnNull()
    {
        $this->chainSelect->select();
    }

    public function getCases()
    {
        return array(
            array(array('selector1' => true), false),
            array(array('selector1' => true), true),
            array(array('selector1' => false, 'selector2' => true), true),
            array(array('selector1' => false, 'selector2' => false), true, true),
        );
    }

    /**
     * @dataProvider getCases
     */
    public function testLogging($selectorState, $withLogging, $expectException = false)
    {
        $logCount = array(
            'info' => 0,
            'warning' => 0,
        );

        foreach ($selectorState as $selector => $state) {
            if (true === $state) {

                $this->$selector->expects($this->once())
                    ->method('select')
                    ->will($this->returnValue($this->site));
                $logCount['info']++;
            } else {
                $this->$selector->expects($this->once())
                    ->method('select')
                    ->will($this->throwException(new SiteNotFoundException('test')));
                $logCount['warning']++;
            }
        }

        if ($withLogging) {
            $this->logger->expects($this->exactly($logCount['info']))
                ->method('info');
            $this->logger->expects($this->exactly($logCount['warning']))
                ->method('warning');
        }

        if ($expectException) {
            $this->setExpectedException('DCMS\Bundle\CoreBundle\Site\Exception\SiteNotFoundException');
        }

        $this->chainSelect->select();
    }
}

