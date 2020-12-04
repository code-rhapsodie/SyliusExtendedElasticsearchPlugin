<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

interface SearchPropertyNameResolverRegistryInterface
{
    public function addPropertyNameResolver(ConcatedNameResolverInterface $propertyNameResolver): void;

    /**
     * @return ConcatedNameResolverInterface[]
     */
    public function getPropertyNameResolvers(): array;
}
