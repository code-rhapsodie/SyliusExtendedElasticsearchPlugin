<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use Sylius\Component\Core\Model\ChannelInterface;

interface SearchConfigurationRepositoryInterface
{
    public function findSearchableByChannel(ChannelInterface $channel): array;
}
