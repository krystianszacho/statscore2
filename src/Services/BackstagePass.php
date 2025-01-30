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

        $this->item->quality++;
        if ($this->item->sell_in < 10) $this->item->quality++;
        if ($this->item->sell_in < 5) $this->item->quality++;

        $this->item->quality = min(50, $this->item->quality);
    }
}
