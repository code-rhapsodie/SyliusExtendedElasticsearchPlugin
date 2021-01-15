<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\DependencyInjection\Compiler\RegisterFacetTypePass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class CodeRhapsodieSyliusExtendedElasticsearchPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterFacetTypePass());
    }
}
