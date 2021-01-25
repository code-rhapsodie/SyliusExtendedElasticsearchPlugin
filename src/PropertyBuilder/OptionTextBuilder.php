<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\OptionTextPropertyNameResolverInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductOptionValueTranslationInterface;

final class OptionTextBuilder extends AbstractBuilder
{
    /** @var OptionTextPropertyNameResolverInterface */
    private $optionTextNameResolver;

    public function __construct(OptionTextPropertyNameResolverInterface $optionTextNameResolver)
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
                $option = $productOptionValue->getOption();
                foreach ($productOptionValue->getTranslations() as $translation) {
                    /** @var $translation ProductOptionValueTranslationInterface */
                    $index = $this->optionTextNameResolver->resolvePropertyName($option, $translation->getLocale());
                    $options = $document->has($index) ? $document->get($index) : [];
                    $options[] = $translation->getValue();

                    $document->set($index, array_values(array_unique($options)));
                }
            }
        }
    }
}
