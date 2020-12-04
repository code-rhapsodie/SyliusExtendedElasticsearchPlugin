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

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\ProductOptionsContext;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\ProductOptionsContextInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\TaxonContextInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ProductOptionsFinderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;

final class ProductOptionsContextSpec extends ObjectBehavior
{
    function let(
        TaxonContextInterface $taxonContext,
        ProductOptionsFinderInterface $optionsFinder
    ): void {
        $this->beConstructedWith($taxonContext, $optionsFinder);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductOptionsContext::class);
    }

    function it_implements_product_options_context_interface(): void
    {
        $this->shouldHaveType(ProductOptionsContextInterface::class);
    }

    function it_gets_options(
        TaxonContextInterface $taxonContext,
        ProductOptionsFinderInterface $optionsFinder,
        TaxonInterface $taxon
    ): void {
        $taxonContext->getTaxon()->willReturn($taxon);

        $optionsFinder->findByTaxon($taxon)->willReturn([]);

        $this->getOptions()->shouldBeEqualTo([]);
    }
}
