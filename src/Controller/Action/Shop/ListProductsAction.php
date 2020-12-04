<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Action\Shop;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\DataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\PaginationDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\SortDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ShopProductsFinderInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type\ShopProductsFilterType;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class ListProductsAction
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var DataHandlerInterface */
    private $shopProductListDataHandler;

    /** @var SortDataHandlerInterface */
    private $shopProductsSortDataHandler;

    /** @var PaginationDataHandlerInterface */
    private $paginationDataHandler;

    /** @var ShopProductsFinderInterface */
    private $shopProductsFinder;

    /** @var EngineInterface */
    private $templatingEngine;

    public function __construct(
        FormFactoryInterface $formFactory,
        DataHandlerInterface $shopProductListDataHandler,
        SortDataHandlerInterface $shopProductsSortDataHandler,
        PaginationDataHandlerInterface $paginationDataHandler,
        ShopProductsFinderInterface $shopProductsFinder,
        EngineInterface $templatingEngine
    ) {
        $this->formFactory = $formFactory;
        $this->shopProductListDataHandler = $shopProductListDataHandler;
        $this->shopProductsSortDataHandler = $shopProductsSortDataHandler;
        $this->paginationDataHandler = $paginationDataHandler;
        $this->shopProductsFinder = $shopProductsFinder;
        $this->templatingEngine = $templatingEngine;
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->createNamed(null, ShopProductsFilterType::class);
        $form->handleRequest($request);
        $requestData = array_merge(
            $form->getData(),
            $request->query->all(),
            ['slug' => $request->get('slug')]
        );

        if (!$form->isValid()) {
            $requestData = $this->clearInvalidEntries($form, $requestData);
        }

        $data = array_merge(
            $this->shopProductListDataHandler->retrieveData($requestData),
            $this->shopProductsSortDataHandler->retrieveData($requestData),
            $this->paginationDataHandler->retrieveData($requestData)
        );

        $template = $request->get('template');
        $products = $this->shopProductsFinder->find($data);

        return $this->templatingEngine->renderResponse($template, [
            'form' => $form->createView(),
            'products' => $products,
            'taxon' => $data['taxon'],
        ]);
    }

    private function clearInvalidEntries(FormInterface $form, array $requestData): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($form->getErrors(true, true) as $error) {
            $errorOrigin = $error->getOrigin();
            $propertyAccessor->setValue(
                $requestData,
                ($errorOrigin->getParent()->getPropertyPath() ?? '') . $errorOrigin->getPropertyPath(),
                ''
            );
        }

        return $requestData;
    }
}
