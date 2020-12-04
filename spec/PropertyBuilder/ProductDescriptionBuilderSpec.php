<?php

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\AbstractBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\ProductDescriptionBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\PropertyBuilderInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\ConcatedNameResolverInterface;
use FOS\ElasticaBundle\Event\TransformEvent;
use PhpSpec\ObjectBehavior;

final class ProductDescriptionBuilderSpec extends ObjectBehavior
{
    function let(ConcatedNameResolverInterface $productNameNameResolver): void
    {
        $this->beConstructedWith($productNameNameResolver);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductDescriptionBuilder::class);
        $this->shouldHaveType(AbstractBuilder::class);
    }

    function it_implements_property_builder_interface(): void
    {
        $this->shouldHaveType(PropertyBuilderInterface::class);
    }

    function it_consumes_event(TransformEvent $event): void
    {
        $this->consumeEvent($event);
    }
}
