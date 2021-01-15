<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\ModelTransformer;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeRegistryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FacetTypeChoiceModelTransformer implements DataTransformerInterface
{
    /** @var FacetTypeRegistryInterface */
    private $facetTypeRegistry;

    public function __construct(FacetTypeRegistryInterface $facetTypeRegistry)
    {
        $this->facetTypeRegistry = $facetTypeRegistry;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return $this->facetTypeRegistry->get($value);
    }

    public function reverseTransform($value)
    {
        /** @var $value FacetTypeInterface */
        return $value->getKey();
    }
}
