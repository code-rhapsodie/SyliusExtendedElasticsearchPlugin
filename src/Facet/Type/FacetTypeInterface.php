<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

interface FacetTypeInterface
{
    public function getKey(): string;

    /**
     * Translation key for this facet type label
     */
    public function getLabel(): string;
}
