<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchPropertyNameResolverRegistryInterface;
use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class SearchProductsQueryBuilder implements QueryBuilderInterface
{
    public const QUERY_KEY = 'query';

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

    public function buildQuery(array $data): ?AbstractQuery
    {
        if (!array_key_exists(self::QUERY_KEY, $data)) {
            throw new \RuntimeException(
                sprintf(
                    'Could not build search products query because there\'s no "query" key in provided data. ' .
                    'Got the following keys: %s',
                    implode(', ', array_keys($data))
                )
            );
        }
        $query = $data[self::QUERY_KEY];
        if (!is_string($query)) {
            throw new \RuntimeException(
                sprintf(
                    'Could not build search products query because the provided "query" is expected to be a string ' .
                    'but "%s" is given.',
                    is_object($query) ? get_class($query) : gettype($query)
                )
            );
        }

        $bool = new BoolQuery();
        $bool->addMust($this->textQueryBuilder->buildQuery([TextQueryBuilder::QUERY_FIELD => $query]));
        $bool->addFilter($this->isEnabledQueryBuilder->buildQuery([]));
        $bool->addFilter($this->hasChannelQueryBuilder->buildQuery([]));

        return $bool;
    }
}
