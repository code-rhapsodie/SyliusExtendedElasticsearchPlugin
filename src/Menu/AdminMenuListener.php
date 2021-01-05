<?php


namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Menu;


use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newConfiguration = $menu
            ->addChild('newConf')
            ->setLabel('Extended Search')
        ;

        $newConfiguration
            ->addChild('Exclude Attributes', ['route' => 'cr_sylius_extended_elasticsearch_plugin_admin_exclude_attribute_index'])
            ->setLabel('Product List Filter Attribute Exclusion')
        ;

        $newConfiguration
            ->addChild('Exclude Options', ['route' => 'cr_sylius_extended_elasticsearch_plugin_admin_exclude_option_index'])
            ->setLabel('Product List Filter Option Exclusion')
        ;
    }
}