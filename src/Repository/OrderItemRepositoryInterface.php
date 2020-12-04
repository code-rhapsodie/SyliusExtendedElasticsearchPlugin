<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Repository;

use Sylius\Component\Core\Model\ProductVariantInterface;

interface OrderItemRepositoryInterface
{
    public function countByVariant(ProductVariantInterface $variant): int;
}
