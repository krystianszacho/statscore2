<?php

namespace App\Services;

use App\Models\Item;

abstract class ItemBase
{
    protected Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    abstract public function update(): void;
}
