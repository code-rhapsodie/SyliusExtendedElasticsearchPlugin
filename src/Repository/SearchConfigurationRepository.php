<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\TaxonInterface;

final class SearchConfigurationRepository extends EntityRepository implements SearchConfigurationRepositoryInterface
{
    public function findSearchableAndGlobalByChannel(ChannelInterface $channel): array
    {
        $qb = $this->createQueryBuilder('sc');

        return $qb
            ->andWhere('sc.searchable = true')
            ->andWhere('sc.usedInGlobalSearch = true')
            ->andWhere($qb->expr()->isMemberOf(':channel', 'sc.channels'))
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchableByChannelAndTaxon(ChannelInterface $channel, TaxonInterface $taxon): array
    {
        $qb = $this->createQueryBuilder('sc');

        return $qb
            ->andWhere('sc.searchable = true')
            ->andWhere($qb->expr()->isMemberOf(':channel', 'sc.channels'))
            ->andWhere($qb->expr()->isMemberOf(':taxon', 'sc.taxons'))
            ->setParameter('channel', $channel)
            ->setParameter('taxon', $taxon)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFilterableAndGlobalByChannel(ChannelInterface $channel): array
    {
        $qb = $this->createQueryBuilder('sc');

        return $qb
            ->andWhere('sc.filterable = true')
            ->andWhere('sc.usedInGlobalSearch = true')
            ->andWhere($qb->expr()->isMemberOf(':channel', 'sc.channels'))
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFilterableByChannelAndTaxon(ChannelInterface $channel, TaxonInterface $taxon): array
    {
        $qb = $this->createQueryBuilder('sc');

        return $qb
            ->andWhere('sc.filterable = true')
            ->andWhere($qb->expr()->isMemberOf(':channel', 'sc.channels'))
            ->andWhere($qb->expr()->isMemberOf(':taxon', 'sc.taxons'))
            ->setParameter('channel', $channel)
            ->setParameter('taxon', $taxon)
            ->getQuery()
            ->getResult()
        ;
    }
}
