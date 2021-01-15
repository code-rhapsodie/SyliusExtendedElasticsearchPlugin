<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception;

final class FacetTypeNotFoundException extends \Exception
{
    public static function create(string $key, array $knownKeys): self
    {
        return new self(sprintf(
            'Unknown facet type key "%s". Known keys are %s.',
            $key,
            implode(', ', $knownKeys)
        ));
    }
}
