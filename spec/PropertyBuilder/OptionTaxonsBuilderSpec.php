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

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository\ProductVariantRepositoryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\AbstractBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\Mapper\ProductTaxonsMapperInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\OptionTaxonsBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyBuilder\PropertyBuilderInterface;
use FOS\ElasticaBundle\Event\TransformEvent;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class OptionTaxonsBuilderSpec extends ObjectBehavior
{
    function let(
        RepositoryInterface $productOptionValueRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductTaxonsMapperInterface $productTaxonsMapper
    ): void {
        $this->beConstructedWith(
            $productOptionValueRepository,
            $productVariantRepository,
            $productTaxonsMapper,
            'taxons'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(OptionTaxonsBuilder::class);
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
