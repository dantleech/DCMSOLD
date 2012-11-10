<?php

namespace DCMS\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class ModuleListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dcms:module:list');
        $this->setDescription('List all registered modules');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mm = $this->getContainer()->get('dcms_core.module_manager');
        $modules = $mm->getModules();

        foreach ($modules as $module) {
            $output->writeln('<info>Module:</info> '.$module->getName());
            $epds = $module->getEndpointDefinitions();
            foreach ($epds as  $epd) {
                $output->writeln('  <comment>EPD for:</comment> '.$epd->getContentFQN());
            }
        }
    }
}
