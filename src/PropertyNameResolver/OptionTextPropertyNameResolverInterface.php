<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use Sylius\Component\Product\Model\ProductOptionInterface;

interface OptionTextPropertyNameResolverInterface
{
    public function resolvePropertyName(ProductOptionInterface $attribute, string $localeCode): string;
}
