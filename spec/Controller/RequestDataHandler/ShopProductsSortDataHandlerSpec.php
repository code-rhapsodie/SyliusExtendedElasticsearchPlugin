<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context\TaxonContextInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\ShopProductsSortDataHandler;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\SortDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\ConcatedNameResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\TaxonInterface;

final class ShopProductsSortDataHandlerSpec extends ObjectBehavior
{
    function let(
        ConcatedNameResolverInterface $channelPricingNameResolver,
        ChannelContextInterface $channelContext,
        TaxonContextInterface $taxonContext,
        ConcatedNameResolverInterface $taxonPositionNameResolver
    ): void {
        $this->beConstructedWith(
            $channelPricingNameResolver,
            $channelContext,
            $taxonContext,
            $taxonPositionNameResolver,
            'sold_units',
            'created_at',
            'price'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShopProductsSortDataHandler::class);
    }

    function it_implements_sort_data_handler_interface(): void
    {
        $this->shouldHaveType(SortDataHandlerInterface::class);
    }

    function it_retrieves_data(
        TaxonContextInterface $taxonContext,
        TaxonInterface $taxon,
        ConcatedNameResolverInterface $taxonPositionNameResolver
    ): void
    {
        $taxonContext->getTaxon()->willReturn($taxon);
        $taxon->getCode()->willReturn('t_shirt');
        $taxonPositionNameResolver->resolvePropertyName('t_shirt')->willReturn('taxon_position_t_shirts');

        $this->retrieveData([])->shouldBeEqualTo([
            'sort' => [
                'taxon_position_t_shirts' => [
                    'order' => SortDataHandlerInterface::SORT_ASC_INDEX,
                    'unmapped_type' => 'keyword',
                ],
            ],
        ]);
    }
}
