<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

class SearchConfiguration implements ResourceInterface
{
    /** @var int */
    private $id;

    /** @var ProductAttributeInterface|null */
    private $attribute;

    /** @var ProductOptionInterface|null */
    private $option;

    /** @var Collection */
    private $taxons;

    /** @var Collection */
    private $channels;

    /** @var bool */
    private $usedInGlobalSearch;

    /** @var bool */
    private $searchable;

    /** @var bool */
    private $filterable;

    /** @var string|null */
    private $facetType;

    /** @var array */
    private $filterOptions;

    public function __construct()
    {
        $this->taxons = new ArrayCollection();
        $this->channels = new ArrayCollection();
        $this->usedInGlobalSearch = true;
        $this->searchable = false;
        $this->filterable = false;
        $this->filterOptions = [];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAttribute(): ?ProductAttributeInterface
    {
        return $this->attribute;
    }

    public function getOption(): ?ProductOptionInterface
    {
        return $this->option;
    }

    public function getTaxons(): Collection
    {
        return $this->taxons;
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function isUsedInGlobalSearch(): bool
    {
        return $this->usedInGlobalSearch;
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    public function getFacetType(): ?string
    {
        return $this->facetType;
    }

    public function getFilterOptions(): array
    {
        return $this->filterOptions;
    }

    public function setAttribute(?ProductAttributeInterface $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function setOption(?ProductOptionInterface $option): self
    {
        $this->option = $option;

        return $this;
    }

    public function setTaxons(Collection $taxons): self
    {
        $this->taxons = $taxons;

        return $this;
    }

    public function setChannels(Collection $channels): self
    {
        $this->channels = $channels;

        return $this;
    }

    public function setUsedInGlobalSearch(bool $usedInGlobalSearch): self
    {
        $this->usedInGlobalSearch = $usedInGlobalSearch;

        return $this;
    }

    public function setSearchable(bool $searchable): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function setFilterable(bool $filterable): self
    {
        $this->filterable = $filterable;

        return $this;
    }

    public function setFacetType(?string $facetType): self
    {
        $this->facetType = $facetType;

        return $this;
    }

    public function setFilterOptions(array $filterOptions): self
    {
        $this->filterOptions = $filterOptions;

        return $this;
    }
}
