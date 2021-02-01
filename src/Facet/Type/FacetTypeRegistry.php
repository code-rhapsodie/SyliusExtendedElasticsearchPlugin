<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception\FacetTypeKeyAlreadyRegisteredException;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception\FacetTypeNotFoundException;

final class FacetTypeRegistry implements FacetTypeRegistryInterface
{
    /** @var FacetTypeInterface[] */
    private $registry;

    public function __construct()
    {
        $this->registry = [];
    }

    public function add(FacetTypeInterface $facetType): void
    {
        $key = $facetType->getKey();
        if (isset($this->registry[$key])) {
            throw FacetTypeKeyAlreadyRegisteredException::create($facetType, $this->registry[$key]);
        }

        $this->registry[$key] = $facetType;
    }

    public function all(): iterable
    {
        return $this->registry;
    }

    public function get(string $key): FacetTypeInterface
    {
        if (!isset($this->registry[$key])) {
            throw FacetTypeNotFoundException::create($key, array_keys($this->registry));
        }

        return $this->registry[$key];
    }
}
