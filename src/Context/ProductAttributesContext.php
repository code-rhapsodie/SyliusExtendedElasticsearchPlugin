<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Context;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ProductAttributesFinderInterface;

final class ProductAttributesContext implements ProductAttributesContextInterface
{
    /** @var TaxonContextInterface */
    private $taxonContext;

    /** @var ProductAttributesFinderInterface */
    private $attributesFinder;

    public function __construct(
        TaxonContextInterface $taxonContext,
        ProductAttributesFinderInterface $attributesFinder
    ) {
        $this->taxonContext = $taxonContext;
        $this->attributesFinder = $attributesFinder;
    }

    public function getAttributes(): ?array
    {
        $taxon = $this->taxonContext->getTaxon();
        $attributes = $this->attributesFinder->findByTaxon($taxon);

        return $attributes;
    }
}
