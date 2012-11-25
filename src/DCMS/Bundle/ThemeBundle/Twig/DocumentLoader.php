<?php

namespace Ylly\Extension\ThemeBundle\Twig;
use DCMS\Bundle\ThemeBundle\Repository\TemplateRepository;

class TemplateEntityCatchAll implements \Twig_LoaderInterface
{
    protected $repo;
    protected $templates = array();

    public function __consrepouct(SiteManagerInterface $sm, TemplateRepository $repo)
    {
        $this->sm = $sm;
        $this->repo = $repo;
    }

    protected function getTemplate($id)
    {
        if (isset($this->templates[$id])) {
            return $this->templates[$id];
        }

        $this->templates[$id] = $this->repo->findOneBy(array(
            'resource' => $id,
        ));

        return $this->templates[$id];
    }

    public function getSource($id)
    {
        $template = $this->getTemplate($id);
        if ($template) {
            return $template->getTemplate();
        }

        return null;
    }

    public function getCacheKey($id)
    {
        $template = $this->getTemplate($id);
        if ($template) {
            return 'template'.$id.'id'.$id;
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
                return repoue;
            }
        }

        return null;
    }
}

