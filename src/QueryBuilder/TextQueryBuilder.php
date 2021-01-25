<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchConfigurationNameResolverInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchPropertyNameResolverRegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository\SearchConfigurationRepositoryInterface;
use Elastica\Query\AbstractQuery;
use Elastica\Query\MultiMatch;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class TextQueryBuilder implements QueryBuilderInterface
{
    public const QUERY_FIELD = 'query';

    /** @var string */
    private $localeCode;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var SearchPropertyNameResolverRegistryInterface */
    private $searchPropertyNameResolverRegistry;

    /** @var SearchConfigurationRepositoryInterface */
    private $searchConfigurationRepository;

    /** @var SearchConfigurationNameResolverInterface */
    private $searchConfigurationNameResolver;

    public function __construct(
        string $localeCode,
        ChannelContextInterface $channelContext,
        SearchPropertyNameResolverRegistryInterface $searchPropertyNameResolverRegistry,
        SearchConfigurationRepositoryInterface $searchConfigurationRepository,
        SearchConfigurationNameResolverInterface $searchConfigurationNameResolver
    ) {
        $this->localeCode = $localeCode;
        $this->channelContext = $channelContext;
        $this->searchPropertyNameResolverRegistry = $searchPropertyNameResolverRegistry;
        $this->searchConfigurationRepository = $searchConfigurationRepository;
        $this->searchConfigurationNameResolver = $searchConfigurationNameResolver;
    }

    public function buildQuery(array $data): ?AbstractQuery
    {
        $query = $data[self::QUERY_FIELD];

        $multiMatch = new MultiMatch();
        $multiMatch->setQuery($query);
        $multiMatch->setFuzziness('AUTO');
        $fields = [];
        foreach ($this->searchPropertyNameResolverRegistry->getPropertyNameResolvers() as $propertyNameResolver) {
            $fields[] = $propertyNameResolver->resolvePropertyName($this->localeCode);
        }
        foreach ($this->searchConfigurationRepository->findSearchableByChannel($this->channelContext->getChannel()) as $searchConfiguration) {
            $fields[] = $this->searchConfigurationNameResolver->resolveTextName($searchConfiguration, $this->localeCode);
        }
        $multiMatch->setFields($fields);

        return $multiMatch;
    }
}
