<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\AbstractBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\Mapper\ProductTaxonsMapperInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\ProductTaxonsBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\PropertyBuilderInterface;
use FOS\ElasticaBundle\Event\TransformEvent;
use PhpSpec\ObjectBehavior;

final class ProductTaxonsBuilderSpec extends ObjectBehavior
{
    function let(ProductTaxonsMapperInterface $productTaxonsMapper): void
    {
        $this->beConstructedWith($productTaxonsMapper, 'taxons');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductTaxonsBuilder::class);
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
