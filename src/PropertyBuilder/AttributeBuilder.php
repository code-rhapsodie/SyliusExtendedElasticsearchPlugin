<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Formatter\StringFormatterInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\ConcatedNameResolverInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class AttributeBuilder extends AbstractBuilder
{
    /** @var ConcatedNameResolverInterface */
    private $attributeNameResolver;

    /** @var StringFormatterInterface */
    private $stringFormatter;

    /** @var LocaleContextInterface */
    private $localeContext;

    public function __construct(
        ConcatedNameResolverInterface $attributeNameResolver,
        StringFormatterInterface $stringFormatter,
        LocaleContextInterface $localeContext
    ) {
        $this->attributeNameResolver = $attributeNameResolver;
        $this->stringFormatter = $stringFormatter;
        $this->localeContext = $localeContext;
    }

    public function consumeEvent(TransformEvent $event): void
    {
        $this->buildProperty($event, ProductInterface::class,
            function (ProductInterface $product, Document $document): void {
                $this->resolveProductAttributes($product, $document);
            });
    }

    private function resolveProductAttributes(ProductInterface $product, Document $document): void
    {
        foreach ($product->getAttributes() as $attributeValue) {
            $attribute = $attributeValue->getAttribute();
            if (!$attribute) {
                continue;
            }
            $attributeCode = $attribute->getCode();
            $index = $this->attributeNameResolver->resolvePropertyName($attributeCode);
            $value = $attributeValue->getValue();

            $attributes = $document->has($index) ? $document->get($index) : [];
            $attributes = array_merge($attributes, (array) $value);

            $document->set($index, array_unique($attributes));
        }
    }
}
