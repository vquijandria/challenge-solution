<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

final class AgedBrieUpdater implements ItemUpdater
{
    public function update(Item $item): void
    {
        $item->sellIn--;

        $increase = ($item->sellIn < 0) ? 2 : 1;
        $item->quality = Quality::increase($item->quality, $increase);
    }
}
