<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Gateway;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\FacetInterface;
use Sylius\Component\Core\Model\TaxonInterface;

interface FacetGatewayInterface
{
    /**
     * @return FacetInterface[]
     */
    public function findForTaxon(TaxonInterface $taxon): array;

    /**
     * @return FacetInterface[]
     */
    public function findGlobal(): array;
}
