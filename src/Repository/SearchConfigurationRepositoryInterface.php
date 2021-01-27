<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\TaxonInterface;

interface SearchConfigurationRepositoryInterface
{
    /**
     * @return SearchConfiguration[]
     */
    public function findSearchableAndGlobalByChannel(ChannelInterface $channel): array;

    /**
     * @return SearchConfiguration[]
     */
    public function findSearchableByChannelAndTaxon(ChannelInterface $channel, TaxonInterface $taxon): array;

    /**
     * @return SearchConfiguration[]
     */
    public function findFilterableAndGlobalByChannel(ChannelInterface $channel): array;

    /**
     * @return SearchConfiguration[]
     */
    public function findFilterableByChannelAndTaxon(ChannelInterface $channel, TaxonInterface $taxon): array;
}
