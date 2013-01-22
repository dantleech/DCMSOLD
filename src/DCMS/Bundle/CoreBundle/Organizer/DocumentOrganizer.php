<?php

namespace DCMS\Bundle\CoreBundle\Organizer;

use Doctrine\ODM\PHPCR\DocumentManager;
use DCMS\Bundle\CoreBundle\Document\Folder;
use DCMS\Bundle\CoreBundle\Site\SiteContext;
use Doctrine\Common\Util\ClassUtils;

class DocumentOrganizer
{
    protected $rules = array();
    protected $sc;
    protected $dm;
    protected $docPaths;

    public function __construct(SiteContext $sc, DocumentManager $dm)
    {
        $this->sc = $sc;
        $this->dm = $dm;
    }

    public function registers(array $docPaths)
    {
        foreach ($docPaths as $class => $docPath) {
            $this->register($class, $docPath);
        }
    }

    public function register($class, $docPath)
    {
        $this->docPaths[$class] = $docPath;
    }

    /**
     * Automatically set the documents parent.
     */
    public function fileDocument($doc)
    {
        $class = ClassUtils::getClass($doc);
        $meta = $this->dm->getClassMetadata($class);
        $refl = $meta->getReflectionClass();
        $prop = $refl->getProperty($meta->parentMapping);
        $prop->setAccessible(true);
        $parent = $prop->getValue($doc);
        if (null === $parent) {
            $folder = $this->getDocumentFolder($class);
            $prop->setValue($doc, $folder);
        }
        $this->dm->persist($doc);
    }

    public function getDocumentFolder($documentClass, $createIfNotExist = true)
    {
        // if not found, check parent classes.
        if (!isset($this->docPaths[$documentClass])) {
            $refl = new \ReflectionClass($documentClass);
            foreach ($this->docPaths as $registeredDocumentClass => $docPath) {
                if ($refl->isSubclassOf($registeredDocumentClass)) {
                    return $this->getDocumentFolder($registeredDocumentClass, $createIfNotExist);
                }
            }
            throw new \InvalidArgumentException(sprintf(
                'Document of class "%s" has not been registered with the document organizer.',
                $documentClass
            ));
        }

        $path = $this->docPaths[$documentClass];

        // replace the site placeholder with the site ID
        if (preg_match('&^@site:.*&', $path)) {
            $path = str_replace('@site:', $this->sc->getSite()->getId(), $path);
        }

        // get path and folder name
        if (preg_match('&(.+)/(.+)$&', $path, $matches)) {
            $parentPath = $matches[1];
            $folderName = $matches[2];
        } else {
            $folderName = str_replace('/', '', $path);
            $parentPath = '/';
        }

        $folder = $this->dm->find(null, $path);

        if ($createIfNotExist && null === $folder) {
            $folder = new Folder;
            $folder->setNodeName($folderName);
            $folder->setParent($this->dm->find(null, $parentPath));
            $this->dm->persist($folder);
        } elseif (null === $folder) {
            throw new FolderDoesNotExist($documentClass);
        }

        return $folder;
    }
}
