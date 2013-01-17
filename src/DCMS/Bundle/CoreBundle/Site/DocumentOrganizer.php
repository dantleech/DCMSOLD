<?php

namespace DCMS\Bundle\CoreBundle\Site;

use Doctrine\ODM\PHPCR\DocumentManager;
use DCMS\Bundle\CoreBundle\Document\Folder;

class DocumentOrganizer
{
    protected $items = array();
    protected $sc;
    protected $dm;

    public function __construct(SiteContext $sc, DocumentManager $dm)
    {
        $this->sc = $sc;
        $this->dm = $dm;
    }

    public function documentsOfClass($documentClass)
    {
        $this->items[$documentClass] = new DocumentOrganizerItem($this->sc, $documentClass);;
        return $this->items[$documentClass];
    }

    public function getDocumentFolder($documentClass, $createIfNotExist = true)
    {
        if (!isset($this->items[$documentClass])) {
            $refl = new \ReflectionClass($documentClass);
            foreach ($this->items as $registeredDocumentClass => $item) {
                if ($refl->isSubclassOf($registeredDocumentClass)) {
                    return $this->getDocumentFolder($registeredDocumentClass, $createIfNotExist);
                }
            }
            throw new \InvalidArgumentException(sprintf(
                'Document of class "%s" has not been registered with the document organizer.',
                $documentClass
            ));
        }

        $item = $this->items[$documentClass];
        $fullPath = $item->getFolderPath();

        $folder = $this->dm->find(null, $fullPath);

        if ($createIfNotExist && null === $folder) {
            $folder = new Folder;
            $folder->setNodeName($item->getFolderName());
            $folder->setParent($this->sc->getSite());
            $this->dm->persist($folder);
        } elseif (null === $folder) {
            throw new Exception\FolderDoesNotExist($documentClass);
        }

        return $folder;
    }
}
