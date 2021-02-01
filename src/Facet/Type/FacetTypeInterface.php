<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\FacetInterface;

interface FacetTypeInterface
{
    public function getKey(): string;

    /**
     * Translation key for this facet type label
     */
    public function getLabel(): string;

    public function createFacet(SearchConfiguration $searchConfiguration): FacetInterface;
}
