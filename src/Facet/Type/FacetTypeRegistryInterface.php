<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

interface FacetTypeRegistryInterface
{
    /**
     * @param FacetTypeInterface $facetType
     */
    public function add(FacetTypeInterface $facetType): void;

    /**
     * @return iterable|FacetTypeInterface[]
     */
    public function all(): iterable;

    /**
     * @param string $key
     *
     * @return FacetTypeInterface
     */
    public function get(string $key): FacetTypeInterface;
}
