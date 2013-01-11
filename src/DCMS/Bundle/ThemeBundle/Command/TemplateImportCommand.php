<?php

namespace DCMS\Bundle\ThemeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class TemplateImportCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('dcms:theme:template:import');
        $this->setDescription('Import a templates from the FS to the CR');
        
        $this->addArgument('fs_path', InputArgument::REQUIRED, 'Path to import to, will create if not exists.');
        $this->addArgument('cr_path', InputArgument::REQUIRED, 'Path to import to, will create if not exists.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dm = $this->getContainer()->get('doctrine_phpcr.odm.document_manager');
        $crPath = $input->getArgument('cr_path');
        $fsPath = $input->getArgument('fs_path');
        $fs = $this->getContainer()->get('filesystem');

        $tmplPath = $fsPath.'/'.$crPath;
        if (!file_exists($tmplPath)) {
            throw new \Exception('Path '.$tmplPath.' does not exist.');
        }

        $output->writeln('Importing templates from: '.$tmplPath);

        $finder = Finder::create()
            ->files()
            ->name('*.twig')
            ->in($tmplPath)
            ->depth(0);

        foreach ($finder->getIterator() as $file) {
            $crTmplPath = $crPath.'/'.basename($file);
            $output->writeln('Importing: '.$file.' to '.$crTmplPath);
            $tmplDoc = $dm->find(null, $crTmplPath);

            if (!$tmplDoc) {
                throw new \Exception('Could not find template: '.$crTmplPath);
            }

            $tmplDoc->setSource(file_get_contents($file));
            $dm->persist($tmplDoc);
        }   

        $dm->flush();
    }
}
