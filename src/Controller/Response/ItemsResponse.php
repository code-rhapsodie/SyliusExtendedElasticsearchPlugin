<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Response;

use CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\Response\DTO\Item;

final class ItemsResponse
{
    /** @var array|Item[] */
    private $items;

    private function __construct(array $itemsList)
    {
        $this->items = $itemsList;
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public function addItem(DTO\Item $item): void
    {
        $this->items[] = $item;
    }

    public function all(): \Traversable
    {
        foreach ($this->items as $item) {
            yield $item->toArray();
        }
    }

    public function toArray(): array
    {
        return ['items' => iterator_to_array($this->all())];
    }
}
