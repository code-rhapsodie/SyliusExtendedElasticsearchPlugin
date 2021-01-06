<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NamePropertyPrefixExtension extends AbstractExtension
{
    /** @var string */
    private $namePropertyPrefix;

    public function __construct(string $namePropertyPrefix)
    {
        $this->namePropertyPrefix = $namePropertyPrefix;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('search_name_field', [$this, 'getName']),
        ];
    }

    public function getName($form)
    {
        return $form[$this->namePropertyPrefix];
    }
}
