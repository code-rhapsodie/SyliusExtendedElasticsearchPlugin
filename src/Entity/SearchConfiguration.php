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

    /**
     * @param ProductAttributeInterface|null $attribute
     *
     * @return SearchConfiguration
     */
    public function setAttribute(?ProductAttributeInterface $attribute): SearchConfiguration
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * @param ProductOptionInterface|null $option
     *
     * @return SearchConfiguration
     */
    public function setOption(?ProductOptionInterface $option): SearchConfiguration
    {
        $this->option = $option;

        return $this;
    }

    /**
     * @param TaxonInterface|null $taxon
     *
     * @return SearchConfiguration
     */
    public function setTaxon(?TaxonInterface $taxon): SearchConfiguration
    {
        $this->taxon = $taxon;

        return $this;
    }

    /**
     * @param ChannelInterface $channel
     *
     * @return SearchConfiguration
     */
    public function setChannel(ChannelInterface $channel): SearchConfiguration
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param bool $searchable
     *
     * @return SearchConfiguration
     */
    public function setSearchable(bool $searchable): SearchConfiguration
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * @param bool $filterable
     *
     * @return SearchConfiguration
     */
    public function setFilterable(bool $filterable): SearchConfiguration
    {
        $this->filterable = $filterable;

        return $this;
    }

    /**
     * @param string|null $facetType
     *
     * @return SearchConfiguration
     */
    public function setFacetType(?string $facetType): SearchConfiguration
    {
        $this->facetType = $facetType;

        return $this;
    }

    /**
     * @param array $filterOptions
     *
     * @return SearchConfiguration
     */
    public function setFilterOptions(array $filterOptions): SearchConfiguration
    {
        $this->filterOptions = $filterOptions;

        return $this;
    }
}
