<?php

namespace DCMS\Bundle\MenuBundle\Block;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Exception\BlockNotFoundException;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use DCMS\Bundle\CoreBundle\Site\SiteContext;

class MenuBlockService extends BaseBlockService
{
    protected $dm;
    protected $sc;

    public function __construct($name, EngineInterface $templating, DocumentManager $dm, SiteContext $sc)
    {
        $this->dm = $dm;
        $this->sc = $sc;
        parent::__construct($name, $templating);
    }

    protected function getMenuRepo()
    {
        return $this->dm->getRepository('DCMS\Bundle\MenuBundle\Document\Menu');
    }

    public function buildEditForm(FormMapper $fm, BlockInterface $block)
    {
        $fm->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('menu', 'phpcr_document', array(
                    'required' => false,
                    'class' => 'DCMS\Bundle\BlogBundle\Document\BlogEndpoint',
                )),
            )
        ));
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function execute(BlockInterface $block, Response $response = null)
    {
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());
        if (null === $settings['menu_name']) {
            $menu = $this->getMenuRepo()->findOneBy(array());
        } else {
            $path = $this->sc->getSite()->getId().'/menus/'.$settings['menu_name'];
            if (!$menu = $this->dm->find(null, $path)) {
                throw new BlockNotFoundException('Could not find menu with ID '.$path);
            }
        }

        if (!$menu) {
            return new Response(200);
        }

        return $this->renderResponse('DCMSMenuBundle:Block:menu.html.twig', array(
            'block' => $block,
            'menu' => $menu
        ));
    }

    public function getDefaultSettings()
    {
        return array(
            'menu_name' => null,
        );
    }
}
