<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SearchProductsQueryBuilder extends AbstractOptionsResolverBasedQueryBuilder
{
    public const QUERY_KEY = 'query';
    public const GLOBAL_KEY = 'global';

    /** @var QueryBuilderInterface */
    private $isEnabledQueryBuilder;

    /** @var QueryBuilderInterface */
    private $hasChannelQueryBuilder;

    /** @var QueryBuilderInterface */
    private $textQueryBuilder;

    public function __construct(
        QueryBuilderInterface $isEnabledQueryBuilder,
        QueryBuilderInterface $hasChannelQueryBuilder,
        QueryBuilderInterface $textQueryBuilder
    ) {
        $this->isEnabledQueryBuilder = $isEnabledQueryBuilder;
        $this->hasChannelQueryBuilder = $hasChannelQueryBuilder;
        $this->textQueryBuilder = $textQueryBuilder;
    }

    protected function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver
            ->setRequired(self::QUERY_KEY)
            ->setAllowedTypes(self::QUERY_KEY, 'string')
            ->setDefault(self::GLOBAL_KEY, false)
            ->setAllowedTypes(self::GLOBAL_KEY, 'bool')
        ;
    }

    protected function doBuildQuery(array $data): ?AbstractQuery
    {
        $query = $data[self::QUERY_KEY];
        $global = $data[self::GLOBAL_KEY];

        $bool = new BoolQuery();
        $bool->addMust($this->textQueryBuilder->buildQuery([
            TextQueryBuilder::QUERY_KEY => $query,
            TextQueryBuilder::GLOBAL_KEY => $global,
        ]));
        $bool->addFilter($this->isEnabledQueryBuilder->buildQuery([]));
        $bool->addFilter($this->hasChannelQueryBuilder->buildQuery([]));

        return $bool;
    }
}
