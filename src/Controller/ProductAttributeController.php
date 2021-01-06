<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributeController extends AbstractController
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function modifyFilterExcluded(int $id): Response
    {
        $productAttribute = $this->repository
            ->find($id);

        if (!$productAttribute) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $productAttribute->setFilterExcluded(!$productAttribute->isFilterExcluded());
        $this->repository->add($productAttribute);

        $this->addFlash('success', 'Exclude has been updated');

        return $this->redirectToRoute('cr_sylius_extended_elasticsearch_plugin_admin_exclude_attribute_index', [
            'id' => $productAttribute->getId(),
        ]);
    }
}
