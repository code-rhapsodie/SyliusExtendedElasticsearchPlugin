<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;

interface SearchConfigurationNameResolverInterface
{
    public function resolveTextName(SearchConfiguration $searchConfiguration, string $locale): string;
}
