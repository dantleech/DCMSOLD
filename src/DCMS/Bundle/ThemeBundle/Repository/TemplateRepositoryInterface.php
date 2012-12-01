<?php

namespace DCMS\Bundle\ThemeBundle\Repository;

interface TemplateRepositoryInterface
{
    /**
     * Return one template or null for
     * the given ID
     *
     * @return Template | null
     */
    public function findTemplate($id);
}

