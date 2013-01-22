<?php

namespace DCMS\Bundle\CoreBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use DCMS\Bundle\CoreBundle\Document\Site;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Helper\HelperSet;
use Jackalope\Tools\Console\Helper\DoctrineDbalHelper;
use Doctrine\ODM\PHPCR\Tools\Console\Command\RegisterSystemNodeTypesCommand;
use Symfony\Component\Console\Input\ArrayInput;
use DCMS\Bundle\CoreBundle\Command\RegisterNodeTypesCommand;
use Jackalope\Tools\Console\Command\InitDoctrineDbalCommand;
use Symfony\Component\Console\Output\NullOutput;
use PHPCR\Util\Console\Helper\PhpcrHelper;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext 
{
    use KernelDictionary;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    protected function getDm()
    {
        $dm = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');
        return $dm;
    }

    protected function getEm()
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected function getDo()
    {
        return $this->getContainer()->get('dcms_core.document_organizer');
    }

    /**
     * @Given /^I have a clean database$/
     */
    public function iHaveACleanDatabase()
    {
        $connection = $this->getEm()->getConnection();
        $driver = $connection->getDriver();
        if (!$driver instanceOf \Doctrine\DBAL\Driver\PDOSqlite\Driver) {
            throw new \Exception('Test database not configured as PDOSqlLite!! Is "'.get_class($driver).'" Not running tests.');
        }
        $params = $connection->getParams();

        $dbFile = sprintf('%s/test.db', 
            $this->getContainer()->getParameter('kernel.cache_dir')
        );
        $backupDbFile = sprintf('%s/test.db.foo', 
            $this->getContainer()->getParameter('kernel.cache_dir')
        );

        if (!file_exists($backupDbFile)) {
            // drop database
            $schemaTool = new SchemaTool($this->getEm());
            $schemaTool->dropDatabase($params['dbname']);

            // update ORM schema
            $emMetas = $this->getEm()->getMetadataFactory()->getAllMetadata();
            $schemaTool->updateSchema($emMetas);

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
            copy($dbFile, $backupDbFile);
        } else {
            unlink($dbFile);
            copy($backupDbFile, $dbFile);
        }
    }

    /**
     * @Given /^I have a site "([^"]*)"$/
     */
    public function iHaveASite($siteName)
    {
        if (null === $this->getDm()->find(null, '/sites/'.$siteName)) {
            $site = new Site;
            $site->setName($siteName);
            $this->getDo()->fileDocument($site);
            $this->getDm()->flush();
        }
    }

    /**
     * @When /^I click "([^"]*)" on the same row as "([^"]*)"$/
     */
    public function iClickOnTheSameRowAs($arg1, $arg2)
    {
        $link = $this->getSession()->getPage()
            ->find('xpath', "//table//tr[td//text()[contains(., '".$arg2."')]]//a[text()[contains(., '".$arg1."')]]");
        $link->click();
    }

    /**
     * @Given /^I am on the dashboard for site "([^"]*)"$/
     */
    public function iAmOnTheDashboardForSite($arg1)
    {
        $this->iHaveASite($arg1);
        $this->visit('/admin/site/'.$arg1.'/dashboard');
    }
}
