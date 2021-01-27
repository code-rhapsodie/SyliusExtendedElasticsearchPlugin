<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchConfigurationNameResolverInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\PropertyNameResolver\SearchPropertyNameResolverRegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository\SearchConfigurationRepositoryInterface;
use Elastica\Query\AbstractQuery;
use Elastica\Query\MultiMatch;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TextQueryBuilder extends AbstractOptionsResolverBasedQueryBuilder
{
    public const QUERY_KEY = 'query';
    public const GLOBAL_KEY = 'global';

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

        $multiMatch = new MultiMatch();
        $multiMatch->setQuery($query);
        $multiMatch->setFuzziness('AUTO');

        $fields = [];
        foreach ($this->searchPropertyNameResolverRegistry->getPropertyNameResolvers() as $propertyNameResolver) {
            $fields[] = $propertyNameResolver->resolvePropertyName($this->localeCode);
        }

        $searchConfigurations = [];
        if ($global) {
            $searchConfigurations = $this->searchConfigurationRepository->findSearchableAndGlobalByChannel(
                $this->channelContext->getChannel()
            );
        }
        // TODO Taxon stuff

        foreach ($searchConfigurations as $searchConfiguration) {
            $fields[] = $this->searchConfigurationNameResolver->resolveTextName($searchConfiguration, $this->localeCode);
        }
        $multiMatch->setFields($fields);

        return $multiMatch;
    }
}
