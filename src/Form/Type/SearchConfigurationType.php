<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Entity\SearchConfiguration;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAttributeChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductOptionChoiceType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SearchConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attribute', ProductAttributeChoiceType::class, [
                'required' => false,
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.attribute',
            ])
            ->add('option', ProductOptionChoiceType::class, [
                'required' => false,
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.option',
            ])
            ->add('taxon', TaxonAutocompleteChoiceType::class, [
                'required' => false,
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.taxon',
            ])
            ->add('channel', ChannelChoiceType::class, [
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.channel',
            ])
            ->add('searchable', CheckboxType::class, [
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.searchable',
            ])
            ->add('filterable', CheckboxType::class, [
                'label' => 'cr_sylius_extended_elasticsearch_plugin.admin.form.search_configuration.label.filterable',
            ])
            ->add('facetType', FacetTypeChoiceType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', SearchConfiguration::class);
    }
}
