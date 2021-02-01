<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet;

use Elastica\Aggregation\AbstractAggregation;
use Elastica\Query\AbstractQuery;

interface FacetInterface
{
    public function getAggregation(): AbstractAggregation;

    public function getQuery($data): AbstractQuery;

    public function getFormType(): string;

    public function getFormOptions(array $data): array;
}
