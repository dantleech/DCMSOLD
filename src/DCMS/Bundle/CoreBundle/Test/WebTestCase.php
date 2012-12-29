<?php

namespace DCMS\Bundle\CoreBundle\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Doctrine\Common\DataFixtures\Executor\PHPCRExecutor;
use Doctrine\Common\DataFixtures\Purger\PHPCRPurger;
use Doctrine\ORM\Tools\SchemaTool;
use Jackalope\Tools\Console\Command\InitDoctrineDbalCommand;
use Jackalope\Tools\Console\Helper\DoctrineDbalHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ODM\PHPCR\Tools\Console\Command\RegisterSystemNodeTypesCommand;
use PHPCR\Util\Console\Helper\PhpcrHelper;
use DCMS\Bundle\CoreBundle\Command\RegisterNodeTypesCommand;

class WebTestCase extends BaseWebTestCase
{
    protected $kernelInstance;

    protected function getContainer()
    {
        if (!$this->kernelInstance) {
            $this->kernelInstance = self::createKernel();
            $this->kernelInstance->boot();
        }

        return $this->kernelInstance->getContainer();
    }

    protected function getDm()
    {
        $dm = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');
        return $dm;
    }

    protected function getEm()
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        return $em;
    }

    protected function loadDocumentFixtures($fixtureClasses)
    {
        $connection = $this->getEm()->getConnection();
        $driver = $connection->getDriver();
        if (!$driver instanceOf \Doctrine\DBAL\Driver\PDOSqlite\Driver) {
            throw new \Exception('Test database not configured as PDOSqlLite!! Is "'.get_class($driver).'" Not running tests.');
        }
        $params = $connection->getParams();

        // drop database
        $schemaTool = new SchemaTool($this->getEm());
        $schemaTool->dropDatabase($params['dbname']);

        // init phpcr
        $initCommand = new InitDoctrineDbalCommand;
        $helperSet = new HelperSet(array(
            new DoctrineDbalHelper($connection)
        ));
        $initCommand->setHelperSet($helperSet);
        $initCommand->run(new ArrayInput(array()), new NullOutput);

        // create test workspace
        $session = $this->getDm()->getPHPCRSession();
        $workspace = $session->getWorkspace();
        $workspace->createWorkspace('test');

        // register system nodes
        $registerNodesCmd = new RegisterSystemNodeTypesCommand;
        $helperSet = new HelperSet(array(
            new PhpcrHelper($session)
        ));
        $registerNodesCmd->setHelperSet($helperSet);
        $registerNodesCmd->run(new ArrayInput(array()), new NullOutput);

        // register endpoint nodes
        $registerNodesCmd = new RegisterNodeTypesCommand;
        $registerNodesCmd->setContainer($this->getContainer());
        $registerNodesCmd->run(new ArrayInput(array()), new NullOutput);

        $loader = $this->getFixtureLoader($fixtureClasses);
        $purger = new PHPCRPurger($this->getDm());
        $executor = new PHPCRExecutor($this->getDm(), $purger);
        $executor->execute($loader->getFixtures(), false);
    }

    protected function getFixtureLoader(array $classNames)
    {
        $loader = new DataFixturesLoader($this->getContainer());

        foreach ($classNames as $className) {
            $this->loadFixtureClass($loader, $className);
        }

        return $loader;
    }

    protected function loadFixtureClass($loader, $className)
    {
        $fixture = new $className();

        if ($loader->hasFixture($fixture)) {
            unset($fixture);
            return;
        }

        $loader->addFixture($fixture);

        if ($fixture instanceof DependentFixtureInterface) {
            foreach ($fixture->getDependencies() as $dependency) {
                $this->loadFixtureClass($loader, $dependency);
            }
        }
    }
}
