<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Gateway;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\FacetInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeRegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository\SearchConfigurationRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\TaxonInterface;

class FacetGateway implements FacetGatewayInterface
{
    /** @var SearchConfigurationRepositoryInterface */
    private $repository;

    /** @var FacetTypeRegistryInterface */
    private $registry;

    /** @var ChannelInterface */
    private $channel;

    /** @var array */
    private $globalFacets;

    public function __construct(
        SearchConfigurationRepositoryInterface $repository,
        FacetTypeRegistryInterface $registry,
        ChannelInterface $channel
    ) {
        $this->repository = $repository;
        $this->registry = $registry;
        $this->channel = $channel;
    }

    public function findForTaxon(TaxonInterface $taxon): array
    {

    }

    public function findGlobal(): array
    {
        if ($this->globalFacets !== null) {
            return $this->globalFacets;
        }

        $this->globalFacets = [];
        foreach ($this->repository->findFilterableAndGlobalByChannel($this->channel) as $searchConfiguration) {
            $facetType = $this->registry->get($searchConfiguration->getFacetType());
            $facet = $facetType->createFacet($searchConfiguration);
            $this->globalFacets[$facet->getAggregation()->getName()] = $facet;
        }

        return $this->globalFacets;
    }
}
