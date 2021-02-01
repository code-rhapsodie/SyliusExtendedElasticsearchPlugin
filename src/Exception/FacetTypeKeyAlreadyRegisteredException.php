<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Facet\Type\FacetTypeInterface;

final class FacetTypeKeyAlreadyRegisteredException extends \Exception
{
    public static function create(FacetTypeInterface $addedfacetType, FacetTypeInterface $existingFacetType): self
    {
        return new self(sprintf(
            'Tried to register facet type %s with key "%s". Key already registered by facet type %s',
            get_class($addedfacetType),
            $addedfacetType->getKey(),
            get_class($existingFacetType)
        ));
    }
}
