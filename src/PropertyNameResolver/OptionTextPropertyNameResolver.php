<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use Sylius\Component\Product\Model\ProductOptionInterface;

final class OptionTextPropertyNameResolver implements OptionTextPropertyNameResolverInterface
{
    /** @var string */
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function resolvePropertyName(ProductOptionInterface $option, string $localeCode): string
    {
        return sprintf(
            '%s_%s_%s',
            $this->prefix,
            $option->getCode(),
            $localeCode
        );
    }
}
