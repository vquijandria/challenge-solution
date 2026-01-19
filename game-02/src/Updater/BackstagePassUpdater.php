<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

final class BackstagePassUpdater implements ItemUpdater
{
    public function update(Item $item): void
    {
        $item->sellIn--;

        if ($item->sellIn < 0) {
            $item->quality = 0;
            return;
        }

        $inc = 1;

        if ($item->sellIn < 10) {
            $inc++;
        }
        if ($item->sellIn < 5) {
            $inc++;
        }

        $item->quality = Quality::increase($item->quality, $inc);
    }
}
