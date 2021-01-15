<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeRegistryInterface;
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\ModelTransformer\FacetTypeChoiceModelTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacetTypeChoiceType extends AbstractType
{
    /** @var FacetTypeRegistryInterface */
    private $facetTypeRegistry;

    public function __construct(FacetTypeRegistryInterface $facetTypeRegistry)
    {
        $this->facetTypeRegistry = $facetTypeRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FacetTypeChoiceModelTransformer($this->facetTypeRegistry));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => $this->facetTypeRegistry->all(),
                'choice_value' => 'getKey',
                'choice_label' => 'getLabel',
            ])
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'cr_sylius_extended_elasticsearch_plugin_facet_type_choice';
    }
}
