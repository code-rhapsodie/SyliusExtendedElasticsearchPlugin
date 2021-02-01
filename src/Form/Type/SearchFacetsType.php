<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Facet\FacetInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\RegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Model\SearchFacets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SearchFacetsType extends AbstractType
{
    /** @var RegistryInterface */
    private $facetRegistry;

    public function __construct(RegistryInterface $facetRegistry)
    {
        $this->facetRegistry = $facetRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['aggregations'] as $facetId => $facetData) {
            if (isset($options['facets'][$facetId])) {
                /** @var FacetInterface $facet */
                $facet = $options['facets'][$facetId];
                $builder->add($facetId, $facet->getFormType(), $facet->getFormOptions($facetData));
            } else {
                $facet = $this->facetRegistry->getFacetById($facetId);
                $choices = [];
                foreach ($facetData['buckets'] as $bucket) {
                    $choices[$facet->getBucketLabel($bucket)] = $bucket['key'];
                }
                if (!empty($choices)) {
                    $builder
                        ->add(
                            $facetId,
                            ChoiceType::class,
                            [
                                'label' => $facet->getLabel(),
                                'choices' => $choices,
                                'expanded' => true,
                                'multiple' => true,
                            ]
                        )
                    ;
                }
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['facets', 'aggregations'])
            ->setAllowedTypes('facets', 'array')
            ->setAllowedTypes('aggregations', 'array')
            ->setDefault('data_class', SearchFacets::class)
        ;
    }
}
