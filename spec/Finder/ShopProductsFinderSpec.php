<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\PaginationDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\SortDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ShopProductsFinder;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ShopProductsFinderInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder\QueryBuilderInterface;
use Elastica\Query\AbstractQuery;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Pagerfanta\Pagerfanta;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ShopProductsFinderSpec extends ObjectBehavior
{
    function let(
        QueryBuilderInterface $shopProductsQueryBuilder,
        PaginatedFinderInterface $productFinder
    ): void {
        $this->beConstructedWith(
            $shopProductsQueryBuilder,
            $productFinder
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShopProductsFinder::class);
    }

    function it_implements_shop_products_finder_interface(): void
    {
        $this->shouldHaveType(ShopProductsFinderInterface::class);
    }

    function it_finds(
        QueryBuilderInterface $shopProductsQueryBuilder,
        PaginatedFinderInterface $productFinder,
        AbstractQuery $boolQuery,
        Pagerfanta $pagerfanta
    ): void {
        $data = [
            SortDataHandlerInterface::SORT_INDEX => null,
            PaginationDataHandlerInterface::PAGE_INDEX => null,
            PaginationDataHandlerInterface::LIMIT_INDEX => null,
        ];

        $shopProductsQueryBuilder->buildQuery($data)->willReturn($boolQuery);

        $productFinder->findPaginated(Argument::any())->willReturn($pagerfanta);

        $this->find($data)->shouldBeEqualTo($pagerfanta);
    }
}
