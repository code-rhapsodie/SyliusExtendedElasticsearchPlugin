<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

interface FacetTypeRegistryInterface
{
    public function add(FacetTypeInterface $facetType): void;

    /**
     * @return iterable|FacetTypeInterface[]
     */
    public function all(): iterable;

    public function get(string $key): FacetTypeInterface;
}
