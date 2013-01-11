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
        $this->setDescription('Export a templates from the CR to the FS');
        $this->addArgument('cr_path', InputArgument::REQUIRED, 'Path to template in CR');
        
        $this->addArgument('fs_path', InputArgument::REQUIRED, 'Path to export to, will create if not exists.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dm = $this->getContainer()->get('doctrine_phpcr.odm.document_manager');
        $crPath = $input->getArgument('cr_path');
        $fsPath = $input->getArgument('fs_path');
        $fs = $this->getContainer()->get('filesystem');

        if (!file_exists($fsPath)) {
            $output->writeln('<info>Creating new directory '.$fsPath.'</info>');
            $fs->mkdir($fsPath);
        }

        $parentdoc = $dm->find(null, $crPath);

        if (!$parentdoc) {
            throw new \Exception('Could not find template dir "'.$crPath.'" in CR');
        }

        $fsParentPath = $fsPath.$parentdoc->getId();

        if (!file_exists($fsParentPath)) {
            $output->writeln('<info>Creating new directory '.$fsParentPath.'</info>');
            $fs->mkdir($fsParentPath);
        }

        $children = $dm->getChildren($parentdoc);

        foreach ($children as $child) {
            if ($child instanceof \DCMS\Bundle\ThemeBundle\Document\Template) {
                $output->writeln('<comment>'.get_class($child).'</comment>');
                $fname = $child->getResource();
                $fpath = $fsParentPath.'/'.$fname;
                $output->writeln('<info> -- Writing '.$fpath.'</info>');
                $source = $child->getSource();
                if (file_exists($fpath)) {
                    $mtime = filemtime($fpath);
                    $fdate = new \DateTime();
                    $fdate->setTimestamp($mtime);
                    if ($fdate > $child->getUpdatedAt()) {
                        $h = $this->getHelper('dialog');
                        $res = $h->ask($output, ' -- Version on disk is newer, are you sure you want to overwrite it?', 'y');
                        if ($res != 'y') {
                            $output->writeln(' -- Skipping');
                            continue;
                        }
                    }
                }
                $output->writeln(' -- Written to: '.$fpath);
                file_put_contents($fpath, $source);
            } else {
                $output->writeln('<comment>'.get_class($child).' is not a template.</comment>');
            }
        }
    }
}
