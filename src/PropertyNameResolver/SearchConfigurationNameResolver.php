<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception\IncompleteSearchConfigurationException;

final class SearchConfigurationNameResolver implements SearchConfigurationNameResolverInterface
{
    /** @var AttributeTextPropertyNameResolverInterface */
    private $attributeTextPropertyNameResolver;

    /** @var OptionTextPropertyNameResolverInterface */
    private $optionTextPropertyNameResolver;

    public function __construct(
        AttributeTextPropertyNameResolverInterface $attributeTextPropertyNameResolver,
        OptionTextPropertyNameResolverInterface $optionTextPropertyNameResolver
    ) {
        $this->attributeTextPropertyNameResolver = $attributeTextPropertyNameResolver;
        $this->optionTextPropertyNameResolver = $optionTextPropertyNameResolver;
    }

    public function resolveTextName(SearchConfiguration $searchConfiguration, string $localeCode): string
    {
        if ($searchConfiguration->getAttribute() !== null) {
            return $this->attributeTextPropertyNameResolver->resolvePropertyName(
                $searchConfiguration->getAttribute(),
                $localeCode
            );
        }

        if ($searchConfiguration->getOption() !== null) {
            return $this->optionTextPropertyNameResolver->resolvePropertyName(
                $searchConfiguration->getOption(),
                $localeCode
            );
        }

        throw IncompleteSearchConfigurationException::create();
    }
}
