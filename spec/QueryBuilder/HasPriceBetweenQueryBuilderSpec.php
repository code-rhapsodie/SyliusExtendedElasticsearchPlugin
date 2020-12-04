<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\ConcatedNameResolverInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\PriceNameResolverInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder\HasPriceBetweenQueryBuilder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder\QueryBuilderInterface;
use Elastica\Query\Range;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;

final class HasPriceBetweenQueryBuilderSpec extends ObjectBehavior
{
    function let(
        PriceNameResolverInterface $priceNameResolver,
        ConcatedNameResolverInterface $channelPricingNameResolver,
        ChannelContextInterface $channelContext,
        CurrencyContextInterface $currencyContext,
        CurrencyConverterInterface $currencyConverter
    ): void {
        $this->beConstructedWith(
            $priceNameResolver,
            $channelPricingNameResolver,
            $channelContext,
            $currencyContext,
            $currencyConverter
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(HasPriceBetweenQueryBuilder::class);
    }

    function it_implements_query_builder_interface(): void
    {
        $this->shouldHaveType(QueryBuilderInterface::class);
    }

    function it_builds_query(
        PriceNameResolverInterface $priceNameResolver,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        CurrencyContextInterface $currencyContext,
        CurrencyInterface $currency,
        ConcatedNameResolverInterface $channelPricingNameResolver
    ): void {
        $channel->getCode()->willReturn('web');
        $channelContext->getChannel()->willReturn($channel);
        $priceNameResolver->resolveMinPriceName()->willReturn('min_price');
        $priceNameResolver->resolveMaxPriceName()->willReturn('max_price');
        $channel->getBaseCurrency()->willReturn($currency);
        $currency->getCode()->willReturn('USD');
        $currencyContext->getCurrencyCode()->willReturn('USD');

        $channelPricingNameResolver->resolvePropertyName('web')->willReturn('web');

        $this->buildQuery([
            'min_price' => '200',
            'max_price' => '1000',
        ])->shouldBeAnInstanceOf(Range::class);
    }

    function it_converts_fractional_currency_properly(
        PriceNameResolverInterface $priceNameResolver,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        CurrencyContextInterface $currencyContext,
        CurrencyInterface $currency,
        ConcatedNameResolverInterface $channelPricingNameResolver
    ): void {
        $channel->getCode()->willReturn('web');
        $channelContext->getChannel()->willReturn($channel);
        $priceNameResolver->resolveMinPriceName()->willReturn('min_price');
        $priceNameResolver->resolveMaxPriceName()->willReturn('max_price');
        $channel->getBaseCurrency()->willReturn($currency);
        $currency->getCode()->willReturn('USD');
        $currencyContext->getCurrencyCode()->willReturn('USD');

        $channelPricingNameResolver->resolvePropertyName('web')->willReturn('web');

        $range = $this->buildQuery([
            'min_price' => '1,23',
            'max_price' => '1000,51',
        ]);

        $range->getParam('web')->shouldReturn(
            [
                'gte' => 123,
                'lte' => 100051,
            ]
        );
    }
}
