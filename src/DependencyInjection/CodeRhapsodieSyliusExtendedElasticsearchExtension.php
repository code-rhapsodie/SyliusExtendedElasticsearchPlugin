<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

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
    }
}
