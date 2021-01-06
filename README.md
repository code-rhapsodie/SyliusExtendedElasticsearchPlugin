## Code Rhapsodie SyliusExtendedElasticsearchPlugin

Working [Sylius](https://sylius.com/) [Elasticsearch](https://www.elastic.co/products/elasticsearch) integration based on [FOSElasticaBundle](https://github.com/FriendsOfSymfony/FOSElasticaBundle). The main goal of this plugin is to support filtering products by 
options, attributes, taxons, channels and name in the front product list page. It totally replaces the default Sylius `sylius_shop_product_index`
route.

What is more, the plugin has a nice Sylius-oriented architecture that allows mapping resources to the Elastic document easier. It is flexible as well,
so that you can customize the existing features for your specific business needs.   

This project is based on [BitBag SyliusElasticsearchPlugin](https://github.com/BitBagCommerce/SyliusElasticsearchPlugin)

## Installation

*Note*: This Plugin currently supports ElasticSearch 5.3.x up to 6.8.x.  ElasticSearch ^7.x is not currently supported.

```bash
$ composer require code-rhapsodie/extended-elasticsearch-plugin
```
    
    
Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    FOS\ElasticaBundle\FOSElasticaBundle::class => ['all' => true],
    CodeRhapsodie\SyliusExtendedElasticsearchPlugin\CodeRhapsodieSyliusExtendedElasticsearchPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@CodeRhapsodieSyliusExtendedElasticsearchPlugin/Resources/config/config.yml" }
```

Import routing **on top** of your `config/routes.yaml` file:
```yaml
# config/routes.yaml

bitbag_sylius_elasticsearch_plugin:
    resource: "@CodeRhapsodieSyliusExtendedElasticsearchPlugin/Resources/config/routing.yml"
```

...and set up the redirection from the default Sylius shop products index page on top of your `config/routes/sylius_shop.yaml`
file.
```
# config/routes/sylius_shop.yaml

redirect_sylius_shop_product_index:
    path: /{_locale}/taxons/{slug}
    controller: Symfony\Bundle\FrameworkBundle\Controller\RedirectController::redirectAction
    defaults:
        route: bitbag_sylius_elasticsearch_plugin_shop_list_products
        permanent: true
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
        slug: .+
```
...and update installed assets with the following command:
```
$ bin/console assets:install
```
...and remove the default ElasticSearch index (`app`) defined by `FOSElasticaBundle` in `config/packages/fos_elastica.yaml`:
```

fos_elastica:
    clients:
        default: { host: localhost, port: 9200 }
    indexes:
        app: ~
```
should become:
```

fos_elastica:
    clients:
        default: { host: localhost, port: 9200 }
```
In the end, with an elasticsearch server running, execute following command:
```
$ bin/console fos:elastica:populate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command. Elastic are created with environment suffix.

## Usage

### Rendering the shop products list

When you go now to the `/{_locale}/products/taxon/{slug}` page, you should see a totally new set of filters. You should see something like this:

<div align="center">
    <img src="https://raw.githubusercontent.com/bitbager/BitBagCommerceAssets/master/BitBagElasticesearchProductIndex.jpg" />
</div>

You might also want to refer the horizontal menu to a new product list page. Follow below instructions to do so:

1. If you haven't done it yet, create two files:
    * `_horizontalMenu.html.twig` in `templates/bundles/SyliusShopBundle/Taxon` directory
    * `_breadcrumb.html.twig` in `templates/bundles/SyliusShopBundle/Product/Show` directory
2. Paste into those files content of respectively `vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/views/Taxon/_horizontalMenu.html.twig` and `vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/views/Product/Show/_breadcrumb.html.twig` files, replacing `sylius_shop_product_index` with `bitbag_sylius_elasticsearch_plugin_shop_list_products` in both of them.
3. Clean your cache with `bin/console cache:clear` command.
4. :tada:

If you're using vertical menu - follow steps above with `_verticalMenu.html.twig` file instead. It's in the same directory as the `horizontal_menu.html.twig` file.

**Be aware! Elasticsearch does not handle dashes well. This plugin depends on the code field in Sylius resources. Please use underscores instead of dashes in your code fields.**

### Excluding options and attributes in the filter menu

You might not want to show some specific options or attributes in the menu. You can set specific parameters for that:
```yml
parameters:
    cr_ees_excluded_filter_options: []
    cr_ees_excluded_filter_attributes: ['book_isbn', 'book_pages']
```

By default all options and attributes are indexed. After you change these parameters, remember to run `bin/console fo:el:po` command again
(a shortcut for `fos:elastica:populate`).

### Exclude attributes and options dynamically from the search filter    
To allow dynamic exclusion of attributes, the `App\Entity\Product\ProductAttribute` class must implement the` CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\FinderExcludable`interface <br/>
For example:
```
use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder\FinderExcludable

class ProductAttribute implements FinderExcludable
```
If it's not the case(`ProductAttribute` doesn't implement `FinderExcludable`), the product attribute exclusion menu list will not be visible and will not appear. <br/>
It works the same way to allow dynamic exclusion of options.





### Reindexing

By default, current indexes listen on all Doctrine events. You can override this setting for each index by overriding index definition in your `config.yml` file:
```yml
fos_elastica:
    indexes:
        bitbag_attribute_taxons:
            types:
                default:
                    persistence:
                        listener:
                            insert: true
                            update: false
                            delete: true
```

Indexes with `bitbag_shop_product`, `bitbag_attribute_taxons` and `bitbag_option_taxons` keys are available so far.

### Site-wide search

This plugin offers a site-wide search feature as well. You have a search box field where you query all products indexed on ElasticSearch. When you enter a query in the search box the results will appear in the search results page.

You can also add search facets (a.k.a. filters) to your search results page. To do so you have to add facets to the `bitbag_sylius_elasticsearch_plugin.facet.registry` service (see an example of this service definition [here](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/tests/Application/config/services.yaml)). A facet is a service which implements the `CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\FacetInterface`. You can implement your own facets from scratch or you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) one of the basic facet implementation included in this plugin, which are:

* [`TaxonFacet`](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/src/Facet/TaxonFacet.php) which allows to filter your search results by taxons using the ElasticSearch [`Terms`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-terms-aggregation.html) aggregation.
* [`AttributeFacet`](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/src/Facet/AttributeFacet.php) which allows to filter your search results by product attributes values using the ElasticSearch [`Terms`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-terms-aggregation.html) aggregation.
* [`OptionFacet`](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/src/Facet/OptionFacet.php) which is the same as `AttributeFacet` but for product options.
* [`PriceFacet`](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/src/Facet/PriceFacet.php) which allows to filter search results by price range the ElasticSearch [`Histogram`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html) aggregation.

You can see an example of the definition of all of these facets [here](https://github.com/code-rhapsodie/SyliusExtendedElasticsearchPlugin/blob/master/tests/Application/config/services.yaml).

## Customization

### Available services you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) and forms you can [extend](http://symfony.com/doc/current/form/create_form_type_extension.html)
```bash
$ bin/console debug:container | grep cr_sylius_extendedelasticsearch_plugin
```

### Parameters you can override in your parameters.yml(.dist) file
```bash
$ bin/console debug:container --parameters | grep cr_ees_
```

## Testing
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ elasticsearch
$ open http://localhost:8080
$ vendor/bin/behat
$ vendor/bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
