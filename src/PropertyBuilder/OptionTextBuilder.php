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
use Sylius\Component\Product\Model\ProductOptionValueTranslationInterface;

final class OptionTextBuilder extends AbstractBuilder
{
    /** @var ConcatedNameResolverInterface */
    private $optionTextNameResolver;

    public function __construct(ConcatedNameResolverInterface $optionTextNameResolver)
    {
        $this->optionTextNameResolver = $optionTextNameResolver;
    }

    public function consumeEvent(TransformEvent $event): void
    {
        $this->buildProperty($event, ProductInterface::class,
            function (ProductInterface $product, Document $document): void {
                $this->resolveProductOptions($product, $document);
            }
        );
    }

    private function resolveProductOptions(ProductInterface $product, Document $document): void
    {
        foreach ($product->getVariants() as $productVariant) {
            foreach ($productVariant->getOptionValues() as $productOptionValue) {
                $optionCode = $productOptionValue->getOption()->getCode();
                foreach ($productOptionValue->getTranslations() as $translation) {
                    /** @var $translation ProductOptionValueTranslationInterface */
                    $index = $this->optionTextNameResolver->resolvePropertyName("{$optionCode}_{$translation->getLocale()}");
                    $options = $document->has($index) ? $document->get($index) : [];
                    $options[] = $translation->getValue();

                    $document->set($index, array_values(array_unique($options)));
                }
            }
        }
    }
}
