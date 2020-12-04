<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Finder;

interface FinderExcludable
{
    public function isFilterExcluded(): bool;
}
