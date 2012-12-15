<?php

namespace DCMS\Bundle\BlogBundle\Block;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use DCMS\Bundle\BlogBundle\Repository\TagRepository;

class TagCloudBlockService extends BaseBlockService
{
    protected $repo;

    public function __construct($name, EngineInterface $templating, TagRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct($name, $templating);
    }

    public function buildEditForm(FormMapper $fm, BlockInterface $block)
    {
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function execute(BlockInterface $block, Response $response = null)
    {
        $wTags = $this->repo->getWeightedTags();
        return $this->renderResponse('DCMSBlogBundle:Block:tagCloud.html.twig', array(
            'block' => $block,
            'wTags' => $wTags
        ));
    }
}
