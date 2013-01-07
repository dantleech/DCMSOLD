<?php

namespace DCMS\Bundle\CoreBundle\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Pretty hacky class to allow us to pass objects ti
 * a normal SF controller - as SF now forces all {{render}}
 * calls to use URI's.
 */
class EndpointControllerFactory
{
    protected $cnp;
    protected $container;

    public function __construct(ContainerInterface $container, ControllerNameParser $cnp)
    {
        $this->cnp = $cnp;
        $this->container = $container;
    }

    public function getResponse($controllerString, $endpoint, $form)
    {
        $string = $this->cnp->parse($controllerString);
        $parts = explode('::', $string);
        list($controller, $action) = $parts;
        $epController = new $controller;
        $epController->setContainer($this->container);
        return $epController->$action($endpoint, $form);
    }
}
