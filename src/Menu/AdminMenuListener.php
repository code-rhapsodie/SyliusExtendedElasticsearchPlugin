<?php


namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Menu;


use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\FinderExcludable;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    private $productAttributeClass;

    private $productOptionClass;

    public function __construct(string $productAttributeClass, string $productOptionClass)
    {
        $this->productAttributeClass = $productAttributeClass;
        $this->productOptionClass = $productOptionClass;
    }

    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

            $newConfiguration = $menu
                ->addChild('newConf')
                ->setLabel('Extended Search');

        if(is_subclass_of($this->productAttributeClass , FinderExcludable::class)) {
            $newConfiguration
                ->addChild('Exclude Attributes', ['route' => 'cr_sylius_extended_elasticsearch_plugin_admin_exclude_attribute_index'])
                ->setLabel('Product List Filter Attribute Exclusion');
        }
        if(is_subclass_of($this->productOptionClass, FinderExcludable::class)) {

            $newConfiguration
                ->addChild('Exclude Options', ['route' => 'cr_sylius_extended_elasticsearch_plugin_admin_exclude_option_index'])
                ->setLabel('Product List Filter Option Exclusion');
        }

    }
}