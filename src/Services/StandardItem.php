<?php

namespace App\Services;

class StandardItem extends ItemBase
{
    public function update(): void
    {
        $qualityDecrease = ($this->item->sell_in <= 0) ? 2 : 1;
        $this->item->quality = max(0, $this->item->quality - $qualityDecrease);
        $this->item->sell_in--; // Dopiero po obniżeniu jakości zmniejszamy sell_in
    }
}
