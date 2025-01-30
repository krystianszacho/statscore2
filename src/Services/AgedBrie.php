<?php

namespace App\Services;

class AgedBrie extends ItemBase
{
    public function update(): void
    {
        $this->item->sell_in--;
        $this->item->quality += ($this->item->sell_in < 0) ? 2 : 1;
        $this->item->quality = min(50, $this->item->quality);
    }
}
