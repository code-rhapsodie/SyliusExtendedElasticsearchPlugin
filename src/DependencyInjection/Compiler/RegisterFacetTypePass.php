<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\DependencyInjection\Compiler;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeRegistryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterFacetTypePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(FacetTypeRegistryInterface::class)) {
            return;
        }

        $registry = $container->findDefinition(FacetTypeRegistryInterface::class);
        foreach ($container->findTaggedServiceIds('cr.sylius_extended_elasticsearch_plugin.facet_type') as $id => $tags) {
            $registry->addMethodCall('add', [new Reference($id)]);
        }
    }
}
