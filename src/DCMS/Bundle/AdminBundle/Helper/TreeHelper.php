<?php

namespace DCMS\Bundle\AdminBundle\Helper;

use Doctrine\ODM\PHPCR\DocumentManager;

class TreeHelper
{
    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function rebuildTree($hierarchy)
    {
        $this->_rebuildIterate($hierarchy);
    }

    public function _rebuildIterate($node)
    {
        $id = $node['id'];
        $ep = null;

        if ($id != 'root') {
            $ep = $this->dm->find('DCMS\Bundle\RoutingBundle\Document\Endpoint', $id);
        }

        $childEps = array();

        if (isset($node['children'])) {
            foreach ($node['children'] as $child) {
                $childEp = $this->_rebuildIterate($child);
                if ($ep) {
                    $ep->addChild($childEp);
                }
            }
        }

        if ($ep) {
            $this->dm->persist($ep);
        }

        return $ep;
    }
}
