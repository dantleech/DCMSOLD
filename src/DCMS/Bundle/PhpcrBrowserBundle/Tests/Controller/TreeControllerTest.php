<?php

namespace DCMS\Bundle\PhpcrBrowserBundle\Tests\Controller;
use DCMS\Bundle\CoreBundle\Test\WebTestCase;

class TreeControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadDocumentFixtures(array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData'
        ));
        $this->client = $this->createClient();
    }

    public function testGetChildrenWithRootPathAction()
    {
        $this->client->request('get', 
            $this->getUrl('dcms_phpcrbrowser_tree_getchildren', array(
                'path' => '/',
            ))
        );

        $resp = $this->client->getResponse();

        $expected= array (
            'sites' =>  array (
                'name' => 'sites',
                'properties' => array (
                    'jcr:primaryType' => array (
                        'value' => 'nt:unstructured',
                        'type' => 7,
                    ),
                    'jcr:mixinTypes' => array (
                        'value' => array (
                            0 => 'phpcr:managed',
                        ),
                        'type' => 7,
                    ),
                    'phpcr:class' => array (
                        'value' => 'DCMS\\Bundle\\CoreBundle\\Document\\Folder',
                        'type' => 1,
                    ), 'phpcr:classparents' => array (
                        'value' => array (),
                        'type' => 1,
                    ),
                ),
            ),
        );

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertEquals('application/json', $resp->headers->get('Content-Type'));
        $this->assertEquals(json_encode($expected), $resp->getContent());
    }
}
