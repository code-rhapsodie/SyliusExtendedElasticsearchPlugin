<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet;

use Elastica\Aggregation\AbstractAggregation;
use Elastica\Aggregation\Terms;

abstract class AbstractFacet implements FacetInterface
{
    /** @var string */
    protected $fieldName;

    /** @var AbstractAggregation */
    private $aggregation;

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public function getAggregation(): AbstractAggregation
    {
        if ($this->aggregation === null) {
            $this->aggregation = $this->createAggregation();
        }

        return $this->aggregation;
    }

    abstract protected function createAggregation(): AbstractAggregation;
}
