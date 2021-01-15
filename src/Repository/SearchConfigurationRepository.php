<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class SearchConfigurationRepository extends EntityRepository implements SearchConfigurationRepositoryInterface
{

}
