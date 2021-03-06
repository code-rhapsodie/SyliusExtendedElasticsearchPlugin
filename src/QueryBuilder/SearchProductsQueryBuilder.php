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

    /** @var SearchPropertyNameResolverRegistryInterface */
    private $searchProperyNameResolverRegistry;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var QueryBuilderInterface */
    private $isEnabledQueryBuilder;

    /** @var QueryBuilderInterface */
    private $hasChannelQueryBuilder;

    public function __construct(
        SearchPropertyNameResolverRegistryInterface $searchProperyNameResolverRegistry,
        LocaleContextInterface $localeContext,
        QueryBuilderInterface $isEnabledQueryBuilder,
        QueryBuilderInterface $hasChannelQueryBuilder
    ) {
        $this->searchProperyNameResolverRegistry = $searchProperyNameResolverRegistry;
        $this->localeContext = $localeContext;
        $this->isEnabledQueryBuilder = $isEnabledQueryBuilder;
        $this->hasChannelQueryBuilder = $hasChannelQueryBuilder;
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

        $multiMatch = new MultiMatch();
        $multiMatch->setQuery($query);
        $multiMatch->setFuzziness('AUTO');
        $fields = [];
        foreach ($this->searchProperyNameResolverRegistry->getPropertyNameResolvers() as $propertyNameResolver) {
            $fields[] = $propertyNameResolver->resolvePropertyName($this->localeContext->getLocaleCode());
        }
        $multiMatch->setFields($fields);
        $bool = new BoolQuery();
        $bool->addMust($multiMatch);
        $bool->addFilter($this->isEnabledQueryBuilder->buildQuery([]));
        $bool->addFilter($this->hasChannelQueryBuilder->buildQuery([]));

        return $bool;
    }
}
