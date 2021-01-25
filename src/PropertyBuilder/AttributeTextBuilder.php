<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\ConcatedNameResolverInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;

final class AttributeTextBuilder extends AbstractBuilder
{
    /** @var ConcatedNameResolverInterface */
    private $attributeTextNameResolver;

    /** @var string */
    private $defaultLocale;

    public function __construct(ConcatedNameResolverInterface $attributeTextNameResolver, string $defaultLocale)
    {
        $this->attributeTextNameResolver = $attributeTextNameResolver;
        $this->defaultLocale = $defaultLocale;
    }

    public function consumeEvent(TransformEvent $event): void
    {
        $this->buildProperty($event, ProductInterface::class,
            function (ProductInterface $product, Document $document): void {
                $this->resolveProductAttributes($product, $document);
            }
        );
    }

    private function resolveProductAttributes(ProductInterface $product, Document $document): void
    {
        foreach ($product->getTranslations() as $productTranslation) {
            /** @var $productTranslation ProductTranslationInterface */
            $locale = $productTranslation->getLocale();

            foreach ($product->getAttributesByLocale($locale, $this->defaultLocale) as $attributeValue) {
                $this->setAttributeValue($attributeValue, $locale, $document);
            }
        }
    }

    private function setAttributeValue(AttributeValueInterface $attributeValue, string $locale, Document $document): void
    {
        $attribute = $attributeValue->getAttribute();
        if (!$attribute) {
            return;
        }

        $index = $this->attributeTextNameResolver->resolvePropertyName("{$attribute->getCode()}_{$locale}");
        $value = $attributeValue->getValue();

        if ($attribute->getType() === 'select') {
            $value = $this->choiceValue($value, $attribute, $locale);
        }

        $document->set($index, $value);
    }

    /**
     * @param string|array $value
     * @param AttributeInterface $attribute
     *
     * @return string|array
     */
    private function choiceValue($value, AttributeInterface $attribute, string $locale)
    {
        $choices = $attribute->getConfiguration()['choices'] ?? [];
        if (is_array($value)) {
            foreach ($value as $i => $item) {
                $value[$i] = $choices[$item][$locale] ?? $choices[$item][$this->defaultLocale] ?? $item;
            }
        } else {
            $value = $choices[$value][$locale] ?? $choices[$item][$this->defaultLocale] ?? $value;
        }

        return $value;
    }
}
