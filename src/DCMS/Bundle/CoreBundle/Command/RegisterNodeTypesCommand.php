<?php

namespace DCMS\Bundle\CoreBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Doctrine\ODM\PHPCR\Translation\Translation;

/**
 * Command to register the phcpr-odm required node types.
 *
 * This command registers the necessary node types to get phpcr odm working
 */
class RegisterNodeTypesCommand extends ContainerAwareCommand
{
    private $dcmsNamespace = 'dcms';
    private $dcmsNamespaceUri = 'http://dcms.dantleech.com/ns';

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('dcms:core:register-node-types')
        ->setDescription('Register DCMS node types');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $session \PHPCR\SessionInterface */
        $session = $this->getContainer()->get('doctrine_phpcr.default_session');
        $ns = $session->getWorkspace()->getNamespaceRegistry();
        $ns->registerNamespace($this->dcmsNamespace, $this->dcmsNamespaceUri);
        $nt = $session->getWorkspace()->getNodeTypeManager();

        if ($session instanceof \Jackalope\Session
            && $session->getTransport() instanceof \Jackalope\Transport\Jackrabbit\Client
        ) {
            $cnd = <<<CND
[dcms:endpoint] > nt:unstructured
CND
            ;

            try {
                $ntm = $session->getWorkspace()->getNodeTypeManager();
                $ntm->registerNodeTypesCnd($cnd, true);
            } catch (\Exception $e) {
                $output->writeln('<error>'.$e->getMessage().'</error>');
                return 1;
            }
        } else {
            $proptpl = $nt->createPropertyDefinitionTemplate();
            $proptpl->setName('phpcr:class');
            $proptpl->setRequiredType(\PHPCR\PropertyType::STRING);
            $tpl = $nt->createNodeTypeTemplate();
            $tpl->setName('dcms:endpoint');
            $tpl->setDeclaredSuperTypeNames(array('nt:unstructured'));
            $props = $tpl->getPropertyDefinitionTemplates();
            $props->offsetSet(null, $proptpl);
            $nt->registerNodeType($tpl, true);
        }

    }
}

