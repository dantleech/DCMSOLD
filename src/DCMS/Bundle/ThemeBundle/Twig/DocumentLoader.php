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
        if (isset($this->templates[$id])) {
            return $this->templates[$id];
        }

        $this->templates[$id] = $this->repo->findTemplate($id);

        return $this->templates[$id];
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

