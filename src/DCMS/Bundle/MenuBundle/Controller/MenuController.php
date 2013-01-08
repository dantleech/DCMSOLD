<?php

namespace DCMS\Bundle\MenuBundle\Controller;

use DCMS\Bundle\CoreBundle\Controller\DCMSController;
use DCMS\Bundle\MenuBundle\Form\MenuCreateType;
use DCMS\Bundle\MenuBundle\Document\Menu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends DCMSController
{
    protected function getMenuRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\MenuBundle\Document\Menu');
    }

    protected function getMenu()
    {
        $menuUuid = $this->get('request')->get('menu_uuid');
        $menu = $this->getMenuRepo()->find($menuUuid);
        return $menu;
    }

    protected function getEndpointRepo()
    {
        return $this->getDm()->getRepository('DCMS\Bundle\CoreBundle\Document\Endpoint');
    }

    protected function getNormalizer()
    {
        $normalizer = new \Symfony\Cmf\Bundle\MenuBundle\Serializer\MenuItemNormalizer($this->getDm());

        return $normalizer;
    }

    protected function getRootDocument()
    {
        // @todo: Manage the document schema.
        return $this->getDm()->find(null, $this->getSite()->getId().'/menus');
    }

    /**
     * @Route("/menu")
     * @Template()
     */
    public function indexAction()
    {
        $menus = $this->getMenurepo()->findAll();
        return array(
            'menus' => $menus
        );
    }

    /**
     * @Route("/menu/_menuList")
     * @Template()
     */
    public function _menuListAction()
    {
        $menus = $this->getMenurepo()->findAll();
        return array(
            'menus' => $menus
        );
    }

    /**
     * @Route("/menu/_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $menu = new Menu;
        $form = $this->createForm(new MenuCreateType, $menu);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $parent = $this->getRootDocument();
                $menu->setParent($parent);
                $this->getDm()->persist($menu);
                $this->getDm()->flush();

                $this->getNotifier()->info('Menu "%s" created', array(
                    $menu->getTitle()
                ));

                return $this->render('DCMSMenuBundle:Menu:createOK.html.twig', array(
                    'menu' => $menu,
                ));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/menu/{menu_uuid}/edit")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $site = $this->getSite();
        $menu = $this->getMenu();
        $treeArray = $this->getNormalizer()->normalize($menu->getRootItem());
        $epsForSelect = $this->getEndpointRepo()->getEndpointsForSelect($this->getSc()->getEndpointPath());;

        return array(
            'menu' => $menu,
            'treeArray' => $treeArray,
            'epsForSelect' => $epsForSelect,
        );
    }

    /**
     * @Route("/menu/{menu_uuid}/update")
     */
    public function updateAction(Request $request)
    {
        $menu = $this->getMenu();
        $tree = $request->get('menu');

        if ($menu->getRootItem()->getId()) {
            $this->getDm()->remove($menu->getRootItem());
            $this->getDm()->flush();
            $this->getDm()->clear();
            $menu = $this->getMenu();
        }

        $rootItem = $this->getNormalizer()->denormalize($tree, 'Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem');
        $menu->setRootItem($rootItem);
        $this->getDm()->persist($menu);
        $this->getDm()->flush();

        return $this->getResponseHelper()->createJsonResponse(true);
    }

    /**
     * @Route("/menu/{menu_uuid}/delete")
     */
    public function deleteAction()
    {
        $menu = $this->getMenu();
        try {
            $this->getDm()->remove($menu);
            $this->getDm()->flush();
            $this->getNotifier()->info('Menu "%s" deleted', array(
                $menu->getTitle(),
            )); 
            return $this->redirect($this->generateUrl('dcms_menu_menu_index', array(
            )));
        } catch (\Excmenution $e) {
            $this->getNotifier()->error($e->getMessage());
            return $this->redirect($this->generateUrl('dcms_menu_menu_edit', array(
                'menu_uuid' => $menu->getUuid(),
            )));
        }
    }
}

