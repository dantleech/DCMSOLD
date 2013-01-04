<?php

namespace DCMS\Bundle\CoreBundle\Tests\Module\Definition;

use DCMS\Bundle\CoreBundle\Module\Definition\EndpointDefinition;

class EndpointDefinitionTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->epDef = new EndpointDefinition(new \stdClass);;
    }

    public function testInterface()
    {
        $this->epDef
            ->setIcon('foobar')
            ->setEditController('edit_route')
            ->setRenderController('HelloController')
            ->setTitle('Foo Endpoint')
            ->setJavascriptDependencies(array(
                'edit' => array(
                    'foo1.js',
                    'foo2.js',
                ),
                'render' => array(
                    'foo3.js',
                    'foo4.js',
                )
            ))
            ->setStylesheetDependencies(array(
                'edit' => array(
                    'foo1.css',
                    'foo2.css',
            )))
            ->setFormTypes(array(
                'edit' => 'DCMS\Foo\Bar\FormType',
            ))
            ->setRoutingResource('@DCMSTestBundle/Resources/config/foobar.xml')
            ->setTitle('To test return value');

        $this->assertEquals('foobar', $this->epDef->getIcon());
        $this->assertEquals('To test return value', $this->epDef->getTitle());
        $this->assertEquals('edit_route', $this->epDef->getEditController());
        $this->assertEquals('HelloController', $this->epDef->getRenderController());
        $this->assertEquals(array(
            'foo1.js',
            'foo2.js',
        ), $this->epDef->getJavascriptDependencies('edit'));
        $this->assertEquals(array(
            'foo1.css',
            'foo2.css',
        ), $this->epDef->getStylesheetDependencies('edit'));
        $this->assertEquals('DCMS\Foo\Bar\FormType', $this->epDef->getFormType('edit'));
        $this->assertEquals('@DCMSTestBundle/Resources/config/foobar.xml', $this->epDef->getRoutingResource());
    }
}
