<?php

namespace App\Services;

class BackstagePass extends ItemBase
{
    public function update(): void
    {
        $this->item->sell_in--;

        if ($this->item->sell_in < 0) {
            $this->item->quality = 0;
            return;
        }

        $qualityIncreaseRules = [
            $this->item->sell_in < 5 => 3,
            $this->item->sell_in < 10 => 2,
            $this->item->sell_in >= 10 => 1
        ];

        $this->item->quality += max(array_filter($qualityIncreaseRules));

        $this->item->quality = min(50, $this->item->quality);
    }
}
