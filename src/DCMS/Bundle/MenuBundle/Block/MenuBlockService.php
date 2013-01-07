<?php

namespace DCMS\Bundle\MenuBundle\Block;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class MenuBlockService extends BaseBlockService
{
    protected $dm;

    public function __construct($name, EngineInterface $templating, DocumentManager $dm)
    {
        $this->dm = $dm;
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
        $menuEp = $this->getMenuRepo()->findOneBy(array());

        if (!$menuEp) {
            return new Response(200);
        }

        return $this->renderResponse('DCMSMenuBundle:Block:menu.html.twig', array(
            'block' => $block,
            'menu' => $menuEp
        ));
    }
}
