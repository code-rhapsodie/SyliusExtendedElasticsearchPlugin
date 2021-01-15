<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

class CheckboxFacetType implements FacetTypeInterface
{
    public function getKey(): string
    {
        return self::class;
    }

    public function getLabel(): string
    {
        return 'cr_sylius_extended_elasticsearch_plugin.facet_type.checkbox.label';
    }
}
