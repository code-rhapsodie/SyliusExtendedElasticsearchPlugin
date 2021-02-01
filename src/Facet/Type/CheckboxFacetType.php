<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception\IncompleteSearchConfigurationException;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\CheckboxFacet;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\FacetInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchConfigurationNameResolverInterface;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class CheckboxFacetType extends AbstractFacetType
{
    /** @var RepositoryInterface */
    private $attributeRepository;

    /** @var RepositoryInterface */
    private $optionRepository;

    /** @var string */
    private $locale;

    /** @var string */
    private $defaultLocale;

    public function __construct(
        SearchConfigurationNameResolverInterface $searchConfigurationNameResolver,
        RepositoryInterface $attributeRepository,
        RepositoryInterface $optionRepository,
        string $locale,
        string $defaultLocale
    ) {
        parent::__construct($searchConfigurationNameResolver);

        $this->attributeRepository = $attributeRepository;
        $this->optionRepository = $optionRepository;
        $this->locale = $locale;
        $this->defaultLocale = $defaultLocale;
    }

    public function getKey(): string
    {
        return self::class;
    }

    public function getLabel(): string
    {
        return 'cr_sylius_extended_elasticsearch_plugin.facet_type.checkbox.label';
    }

    public function createFacet(SearchConfiguration $searchConfiguration): FacetInterface
    {
        if ($searchConfiguration->getAttribute() !== null) {
            $attribute = $searchConfiguration->getAttribute();
            $choices = $this->choicesForAttribute($attribute);
            $label = $attribute->getTranslation()->getName();
        } elseif ($searchConfiguration->getOption() !== null) {
            $option = $searchConfiguration->getOption();
            $choices = $this->choicesForOption($option);
            $label = $option->getTranslation()->getName();
        } else {
            throw IncompleteSearchConfigurationException::create();
        }

        return new CheckboxFacet($this->fieldName($searchConfiguration), $choices, $label);
    }

    private function choicesForAttribute(AttributeInterface $attribute): array
    {
        if ($attribute->getType() !== 'select') {
            return [];
        }

        $attributeChoices = $attribute->getConfiguration()['choices'] ?? [];
        $choices = [];
        foreach ($attributeChoices as $key => $labels) {
            $choices[$key] = $labels[$this->locale] ?? $labels[$this->defaultLocale] ?? $key;
        }

        return $choices;
    }

    private function choicesForOption(ProductOptionInterface $option): array
    {
        $choices = [];
        foreach ($option->getValues() as $value) {
            $choices[$value->getCode()] = $value->getTranslation()->getValue();
        }

        return $choices;
    }
}
