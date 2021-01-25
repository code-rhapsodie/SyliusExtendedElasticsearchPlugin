<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use Sylius\Component\Attribute\Model\AttributeInterface;

interface AttributeTextPropertyNameResolverInterface
{
    public function resolvePropertyName(AttributeInterface $attribute, string $localeCode): string;
}
