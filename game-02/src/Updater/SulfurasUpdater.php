<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

final class SulfurasUpdater implements ItemUpdater
{
    public function update(Item $item): void
    {
        // Sulfuras no cambia sellIn ni quality
        $item->quality = Quality::SULFURAS;
    }
}
