<?php

namespace DCMS\Bundle\ThemeBundle\Twig;
use DCMS\Bundle\ThemeBundle\Repository\TemplateRepositoryInterface;

class DocumentLoader implements \Twig_LoaderInterface
{
    protected $repo;
    protected $templates = array();

    public function __construct(TemplateRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    protected function getTemplate($id)
    {
        $logicalName = (string) $id;
        if (isset($this->templates[$logicalName])) {
            return $this->templates[$logicalName];
        }

        try {
            $template = $this->repo->findTemplate($logicalName);
        } catch (\Exception $e) {
            throw new \Twig_Error_Loader(
                sprintf('Cannot find document for "%s".', $logicalName),
                -1, null, $e
            );
        }
        
        if (!$template) {
            throw new \Twig_Error_Loader(sprintf('Cannot find document for "%s".', $logicalName));
        }

        $this->templates[$logicalName] = $template;

        return $this->templates[$logicalName];
    }

    public function getSource($id)
    {
        $template = $this->getTemplate($id);
        if ($template) {
            return $template->getSource();
        }

        return null;
    }

    public function getCacheKey($id)
    {
        $template = $this->getSource($id);
        if ($template) {
            return $id;
        }

        return null;
    }

    public function isFresh($id, $time)
    {
        if ($template = $this->getTemplate($id)) {
            $templateTs = $template->getUpdatedAt()->format('U');
            if ($templateTs > $time) {
                return false;
            } else {
                return true;
            }
        }

        return null;
    }
}

