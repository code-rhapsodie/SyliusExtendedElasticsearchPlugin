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

    /** @var ConcatedNameResolverInterface */
    private $attributeValuePropertyNameResolver;

    /** @var ConcatedNameResolverInterface */
    private $optionValuePropertyNameResolver;

    public function __construct(
        AttributeTextPropertyNameResolverInterface $attributeTextPropertyNameResolver,
        OptionTextPropertyNameResolverInterface $optionTextPropertyNameResolver,
        ConcatedNameResolverInterface $attributeValuePropertyNameResolver,
        ConcatedNameResolverInterface $optionValuePropertyNameResolver
    ) {
        $this->attributeTextPropertyNameResolver = $attributeTextPropertyNameResolver;
        $this->optionTextPropertyNameResolver = $optionTextPropertyNameResolver;
        $this->attributeValuePropertyNameResolver = $attributeValuePropertyNameResolver;
        $this->optionValuePropertyNameResolver = $optionValuePropertyNameResolver;
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

    public function resolveValueName(SearchConfiguration $searchConfiguration): string
    {
        if ($searchConfiguration->getAttribute() !== null) {
            return $this->attributeValuePropertyNameResolver->resolvePropertyName(
                $searchConfiguration->getAttribute()->getCode()
            );
        }

        if ($searchConfiguration->getOption() !== null) {
            return $this->optionValuePropertyNameResolver->resolvePropertyName(
                $searchConfiguration->getOption()->getCode()
            );
        }

        throw IncompleteSearchConfigurationException::create();
    }
}
