<?php


namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller;


use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\FinderExcludable;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductOptionController extends AbstractController
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/search/excluded-options/toggle/{id}", name="cr_sylius_extended_elasticsearch_plugin_admin_exclude_option_toggle")
     */

    public function modifyFilterExcluded(int $id): Response
    {
        $productOption = $this->repository
            ->find($id);

        if (!$productOption) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $productOption->setFilterExcluded(!$productOption->isFilterExcluded());
        $this->repository->add($productOption);

        $this->addFlash('success', 'Exclude has been updated');

        return $this->redirectToRoute('cr_sylius_extended_elasticsearch_plugin_admin_exclude_option_index', [
            'id' => $productOption->getId()
        ]);

    }


}