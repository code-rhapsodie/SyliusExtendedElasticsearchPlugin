<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Action\Shop;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Block\SearchFormEventListener;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\PaginationDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\RegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Model\Search;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\QueryBuilder\QueryBuilderInterface;
use Elastica\Query;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SearchAction
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var PaginatedFinderInterface */
    private $finder;

    /** @var SearchFormEventListener */
    private $searchFormEventListener;

    /** @var RegistryInterface */
    private $facetRegistry;

    /** @var QueryBuilderInterface */
    private $searchProductsQueryBuilder;

    /** @var PaginationDataHandlerInterface */
    private $paginationDataHandler;

    public function __construct(
        EngineInterface $templatingEngine,
        PaginatedFinderInterface $finder,
        SearchFormEventListener $searchFormEventListener,
        RegistryInterface $facetRegistry,
        QueryBuilderInterface $searchProductsQueryBuilder,
        PaginationDataHandlerInterface $paginationDataHandler
    ) {
        $this->templatingEngine = $templatingEngine;
        $this->finder = $finder;
        $this->searchFormEventListener = $searchFormEventListener;
        $this->facetRegistry = $facetRegistry;
        $this->searchProductsQueryBuilder = $searchProductsQueryBuilder;
        $this->paginationDataHandler = $paginationDataHandler;
    }

    public function __invoke(Request $request): Response
    {
        $template = $request->get('template');
        $form = $this->searchFormEventListener->getForm();
        $form->handleRequest($request);

        $results = null;
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Search $search */
            $search = $form->getData();

            $boolQuery = new Query\BoolQuery();
            $boolQuery->addMust(
                $this->searchProductsQueryBuilder->buildQuery(['query' => $search->getBox()->getQuery()])
            );

            if ($search->getFacets()) {
                foreach ($search->getFacets() as $facetId => $selectedBuckets) {
                    if (!$selectedBuckets) {
                        continue;
                    }
                    $facet = $this->facetRegistry->getFacetById($facetId);
                    $boolQuery->addFilter($facet->getQuery($selectedBuckets));
                }
            }

            $query = new Query($boolQuery);

            $results = $this->finder->findPaginated($query);
            $paginationData = $this->paginationDataHandler->retrieveData($request->query->all());
            $results->setCurrentPage($paginationData[PaginationDataHandlerInterface::PAGE_INDEX]);
            $results->setMaxPerPage($paginationData[PaginationDataHandlerInterface::LIMIT_INDEX]);
        }

        return $this->templatingEngine->renderResponse(
            $template,
            ['results' => $results, 'searchForm' => $form->createView()]
        );
    }
}
