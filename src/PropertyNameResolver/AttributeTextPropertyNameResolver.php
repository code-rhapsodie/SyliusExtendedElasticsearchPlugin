<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver;

use Sylius\Component\Attribute\Model\AttributeInterface;

final class AttributeTextPropertyNameResolver implements AttributeTextPropertyNameResolverInterface
{
    /** @var string */
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function resolvePropertyName(AttributeInterface $attribute, string $localeCode): string
    {
        return sprintf(
            '%s_%s_%s',
            $this->prefix,
            $attribute->getCode(),
            $localeCode
        );
    }
}
