<?php

namespace DCMS\Bundle\CoreBundle\Tests\Repository;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class EndpointRepositoryTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\CoreBundle\Tests\Fixtures\ODM\LoadEndpointData',
        ));
    } 

    public function testRecursiveFind()
    {
    }
}
