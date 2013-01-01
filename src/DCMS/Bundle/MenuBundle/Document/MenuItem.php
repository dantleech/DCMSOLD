<?php

namespace DCMS\Bundle\MenuBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem as BaseMenuItem;

/**
 * @PHPCR\Document()
 */
class MenuItem extends BaseMenuItem
{
}
