<?php

namespace DCMS\Bundle\CoreBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DCMS\Bundle\CoreBundle\Command\ModuleListCommand;

class ModuleListCommandTest extends WebTestCase
{
    public function testList()
    {
        $client = $this->createClient();
        $container = $client->getContainer();
        $command = new ModuleListCommand;
        $command->setContainer($container);
        $in = $this->getMock('Symfony\Component\Console\Input\InputInterface');
        $out = $this->getMock('Symfony\Component\Console\Output\OutputInterface');
        $command->run($in, $out);
    }
}

