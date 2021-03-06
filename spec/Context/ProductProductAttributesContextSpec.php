<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\ProductAttributesContextInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\ProductProductAttributesContext;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\TaxonContextInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ProductAttributesFinderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;

final class ProductProductAttributesContextSpec extends ObjectBehavior
{
    function let(
        TaxonContextInterface $taxonContext,
        ProductAttributesFinderInterface $attributesFinder
    ): void {
        $this->beConstructedWith($taxonContext, $attributesFinder);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductProductAttributesContext::class);
    }

    function it_implements_product_attributes_context_interface(): void
    {
        $this->shouldHaveType(ProductAttributesContextInterface::class);
    }

    function it_gets_attributes(
        TaxonContextInterface $taxonContext,
        ProductAttributesFinderInterface $attributesFinder,
        TaxonInterface $taxon
    ): void {
        $taxonContext->getTaxon()->willReturn($taxon);

        $attributesFinder->findByTaxon($taxon)->willReturn([]);

        $this->getAttributes()->shouldBeEqualTo([]);
    }
}
