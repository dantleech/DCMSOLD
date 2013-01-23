<?php

namespace DCMS\Bundle\PhpcrBrowserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TreeController extends Controller
{
    protected function getPhpcrSession()
    {
        return $this->get('doctrine_phpcr.session');
    }

    /**
     * @Route("/tree")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(pattern="/tree/_children")
     */
    public function getChildrenAction(Request $request)
    {
        $path = $request->get('path');
        if ($path == '/') {
            $node = $this->getPhpcrSession()->getRootNode();
        } else {
            $node = $this->getPhpcrSession()->getNodeByIdentifier($path);
        }

        $children = array();

        foreach ($node->getNodes() as $childName => $childNode) {
            $child = array(
                'id' => str_replace('//', '/', $path.'/'.$childName),
                'name' => $childName,
                'properties' => array(),
            );
            foreach ($childNode->getProperties() as $name => $prop) {
                $child['properties'][$name] = array(
                    'value' => $prop->getValue(),
                    'type' => $prop->getType(),
                );
            }
            $children[$childName] = $child;
        }

        return new Response(json_encode($children), 200, array('Content-Type' => 'application/json'));
    }
}
