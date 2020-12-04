<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet;

interface RegistryInterface
{
    public function addFacet(string $facetId, FacetInterface $facet): void;

    /**
     * @return FacetInterface[]
     */
    public function getFacets(): array;

    public function getFacetById(string $facetId): FacetInterface;
}
