<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Action\Api;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Response\DTO\Item;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Response\ItemsResponse;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\NamedProductsFinderInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Transformer\Product\TransformerInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListProductsByPartialNameAction
{
    /** @var NamedProductsFinderInterface */
    private $namedProductsFinder;

    /** @var TransformerInterface */
    private $productSlugTransformer;

    /** @var TransformerInterface */
    private $productChannelPriceTransformer;

    /** @var TransformerInterface */
    private $productImageTransformer;

    public function __construct(
        NamedProductsFinderInterface $namedProductsFinder,
        TransformerInterface $productSlugResolver,
        TransformerInterface $productChannelPriceResolver,
        TransformerInterface $productImageResolver
    ) {
        $this->namedProductsFinder = $namedProductsFinder;
        $this->productSlugTransformer = $productSlugResolver;
        $this->productChannelPriceTransformer = $productChannelPriceResolver;
        $this->productImageTransformer = $productImageResolver;
    }

    public function __invoke(Request $request): Response
    {
        $itemsResponse = ItemsResponse::createEmpty();

        if (null === $request->query->get('query')) {
            return JsonResponse::create($itemsResponse->toArray());
        }

        $products = $this->namedProductsFinder->findByNamePart($request->query->get('query'));

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            if (null === $productMainTaxon = $product->getMainTaxon()) {
                continue;
            }

            $itemsResponse->addItem(new Item(
                $productMainTaxon->getName(),
                $product->getName(),
                $product->getShortDescription(),
                $this->productSlugTransformer->transform($product),
                $this->productChannelPriceTransformer->transform($product),
                $this->productImageTransformer->transform($product)
            ));
        }

        return JsonResponse::create($itemsResponse->toArray());
    }
}
