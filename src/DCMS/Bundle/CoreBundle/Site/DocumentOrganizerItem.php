<?php

namespace DCMS\Bundle\CoreBundle\Site;

use DCMS\Bundle\CoreBundle\Site\SiteContext;

class DocumentOrganizerItem
{
    protected $sc;
    protected $folderName;
    protected $documentClass;

    public function __construct(SiteContext $sc)
    {
        $this->sc = $sc;
    }

    public function getFolderPath()
    {
        return sprintf('%s/%s', 
            $this->sc->getSite()->getId(),
            $this->getFolderName()
        );
    }

    public function getFolderName()
    {
        if (null === $this->folderName) {
            throw new \Exception(sprintf(
                'Folder name not set for document class "%s"', 
                $this->documentClass
            ));
        }
        return $this->folderName;
    }

    public function belongInFolder($folderName)
    {
        $this->folderName = $folderName;
    }
}
