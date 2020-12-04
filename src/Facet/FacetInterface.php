<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet;

use Elastica\Aggregation\AbstractAggregation;
use Elastica\Query\AbstractQuery;

interface FacetInterface
{
    public function getAggregation(): AbstractAggregation;

    public function getQuery(array $selectedBuckets): AbstractQuery;

    public function getBucketLabel(array $bucket): string;

    public function getLabel(): string;
}
