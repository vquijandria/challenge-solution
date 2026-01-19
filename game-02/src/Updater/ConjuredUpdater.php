<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

final class ConjuredUpdater implements ItemUpdater
{
    public function update(Item $item): void
    {
        $item->sellIn--;

        // Conjured degrada el doble que normal
        $degrade = ($item->sellIn < 0) ? 4 : 2;
        $item->quality = Quality::decrease($item->quality, $degrade);
    }
}
