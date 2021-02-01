<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class CodeRhapsodieSyliusExtendedElasticsearchExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $config, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('cr_ees_filter_attributes_max', $config['filter_attributes_max']);
        $container->setParameter('cr_ees_filter_options_max', $config['filter_options_max']);
        $container->setParameter('cr_ees_shop_name_property_prefix', $config['shop_name_property_prefix']);
        $container->setParameter('cr_ees_excluded_filter_options', $config['excluded_filter']['options']);
        $container->setParameter('cr_ees_excluded_filter_attributes', $config['excluded_filter']['attributes']);

        $this->doctrineMigration($container);
    }

    public function doctrineMigration(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('doctrine_migrations') || !$container->hasExtension('sylius_labs_doctrine_migrations_extra')) {
            return;
        }

        $doctrineConfig = $container->getExtensionConfig('doctrine_migrations');
        $migrationsPath = (array) \array_pop($doctrineConfig)['migrations_paths'];
        $container->prependExtensionConfig('doctrine_migrations', [
            'migrations_paths' => \array_merge(
                $migrationsPath ?? [],
                [
                    'CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Migrations' => '@CodeRhapsodieSyliusExtendedElasticsearchPlugin/Migrations',
                ]
            ),
        ]);

        $container->prependExtensionConfig('sylius_labs_doctrine_migrations_extra', [
            'migrations' => [
                'CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Migrations' => ['Sylius\Bundle\CoreBundle\Migrations'],
            ],
        ]);
    }
}
