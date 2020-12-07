<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Form\Type;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Model\SearchBox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType as SymfonySearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SearchBoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'query',
                SymfonySearchType::class,
                [
                    'label' => false,
                    'attr' => ['placeholder' => 'cr_sylius_extended_elasticsearch_plugin.ui.search_box.query.placeholder'],
                    'constraints' => [new NotBlank()],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', SearchBox::class);
    }
}
