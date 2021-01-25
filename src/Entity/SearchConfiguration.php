<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity;

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

    /** @var TaxonInterface|null */
    private $taxon;

    /** @var ChannelInterface */
    private $channel;

    /** @var bool */
    private $searchable;

    /** @var bool */
    private $filterable;

    /** @var string|null */
    private $facetType;

    /** @var array */
    private $filterOptions;

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

    public function getTaxon(): ?TaxonInterface
    {
        return $this->taxon;
    }

    public function getChannel(): ?ChannelInterface
    {
        return $this->channel;
    }

    public function isSearchable(): ?bool
    {
        return $this->searchable;
    }

    public function isFilterable(): ?bool
    {
        return $this->filterable;
    }

    public function getFacetType(): ?string
    {
        return $this->facetType;
    }

    public function getFilterOptions(): ?array
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

    public function setTaxon(?TaxonInterface $taxon): self
    {
        $this->taxon = $taxon;

        return $this;
    }

    public function setChannel(ChannelInterface $channel): self
    {
        $this->channel = $channel;

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
