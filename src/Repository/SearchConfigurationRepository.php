<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

final class SearchConfigurationRepository extends EntityRepository implements SearchConfigurationRepositoryInterface
{
    public function findSearchableByChannel(ChannelInterface $channel): array
    {
        return $this->findBy([
            'searchable' => true,
            'channel' => $channel,
        ]);
    }
}
