<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use Elastica\Query\AbstractQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractOptionsResolverBasedQueryBuilder implements QueryBuilderInterface
{
    public function buildQuery(array $data): ?AbstractQuery
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $data = $optionsResolver->resolve($data);

        return $this->doBuildQuery($data);
    }

    abstract protected function configureOptions(OptionsResolver $optionsResolver);

    abstract protected function doBuildQuery(array $data): ?AbstractQuery;
}
