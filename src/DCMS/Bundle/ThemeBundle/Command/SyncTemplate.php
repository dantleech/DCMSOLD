<?php

namespace DCMS\Bundle\ThemeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateExportCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('dcms:theme:template:export');
        $this->setDescription('Exports templates from the storage layer to the filesystem');
        $this->addArgument('cr_path', InputArgument::REQUIRED, 'Path to template in CR');
        
        $this->addArgument('out_path', InputArgument::REQUIRED, 'Path to export to, will create if not exists.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
