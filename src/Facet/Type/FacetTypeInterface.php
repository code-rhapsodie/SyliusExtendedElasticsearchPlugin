<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

interface FacetTypeInterface
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * Translation key for this facet type label
     *
     * @return string
     */
    public function getLabel(): string;
}
