<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Action\Shop;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Action\Shop\ListProductsAction;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\DataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\PaginationDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler\SortDataHandlerInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\ShopProductsFinderInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type\ShopProductsFilterType;
use Pagerfanta\Pagerfanta;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListProductsActionSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        DataHandlerInterface $shopProductListDataHandler,
        SortDataHandlerInterface $shopProductsSortDataHandler,
        PaginationDataHandlerInterface $paginationDataHandler,
        ShopProductsFinderInterface $shopProductsFinder,
        EngineInterface $templatingEngine
    ): void {
        $this->beConstructedWith(
            $formFactory,
            $shopProductListDataHandler,
            $shopProductsSortDataHandler,
            $paginationDataHandler,
            $shopProductsFinder,
            $templatingEngine
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ListProductsAction::class);
    }

    function it_renders_product_list(
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        ParameterBag $queryParameters,
        DataHandlerInterface $shopProductListDataHandler,
        SortDataHandlerInterface $shopProductsSortDataHandler,
        PaginationDataHandlerInterface $paginationDataHandler,
        ShopProductsFinderInterface $shopProductsFinder,
        Pagerfanta $pagerfanta,
        FormView $formView,
        EngineInterface $templatingEngine,
        Response $response
    ): void {
        $form->getData()->willReturn([]);
        $form->isValid()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->createView()->willReturn($formView);

        $formFactory->createNamed(null, ShopProductsFilterType::class)->willReturn($form);

        $request->query = $queryParameters;
        $queryParameters->all()->willReturn([]);

        $request->get('template')->willReturn('@Template');
        $request->get('slug')->willReturn(null);

        $shopProductListDataHandler->retrieveData(['slug' => null])->willReturn(['taxon' => null]);
        $shopProductsSortDataHandler->retrieveData(['slug' => null]);
        $paginationDataHandler->retrieveData(['slug' => null]);

        $shopProductsFinder->find(['taxon' => null])->willReturn($pagerfanta);

        $templatingEngine->renderResponse('@Template', Argument::any())->willReturn($response);

        $this->__invoke($request);
    }
}
