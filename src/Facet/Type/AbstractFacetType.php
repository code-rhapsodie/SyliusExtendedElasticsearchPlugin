<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchConfigurationNameResolverInterface;
use Sylius\Component\Locale\Model\LocaleInterface;

abstract class AbstractFacetType implements FacetTypeInterface
{
    /** @var SearchConfigurationNameResolverInterface */
    private $searchConfigurationNameResolver;

    public function __construct(
        SearchConfigurationNameResolverInterface $searchConfigurationNameResolver
    ) {
        $this->searchConfigurationNameResolver = $searchConfigurationNameResolver;
    }

    protected function fieldName(SearchConfiguration $searchConfiguration): string
    {
        return $this->searchConfigurationNameResolver->resolveValueName($searchConfiguration);
    }
}
