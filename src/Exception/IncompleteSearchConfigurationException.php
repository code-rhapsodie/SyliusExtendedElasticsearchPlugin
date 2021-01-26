<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Exception;

class IncompleteSearchConfigurationException extends \Exception
{
    public static function create(): self
    {
        return new self('A SearchConfiguration should have either an attribute or an option set. Neither were set.');
    }
}
