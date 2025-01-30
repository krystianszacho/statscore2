<?php

namespace App\Services;

use App\Models\Item;

final class GildedRose
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        array_walk($this->items, function ($item) {
            $this->getItemHandler($item)->update();
        });
    }

    private function getItemHandler(Item $item): ItemBase
    {
        return match ($item->name) {
            'Aged Brie' => new AgedBrie($item),
            'Backstage passes to a TAFKAL80ETC concert' => new BackstagePass($item),
            'Sulfuras, Hand of Ragnaros' => new Sulfuras($item),
            default => new StandardItem($item),
        };
    }
}
