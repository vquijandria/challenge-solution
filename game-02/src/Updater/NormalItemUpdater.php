<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

final class NormalItemUpdater implements ItemUpdater
{
    public function update(Item $item): void
    {
        $item->sellIn--;

        $degrade = ($item->sellIn < 0) ? 2 : 1;
        $item->quality = Quality::decrease($item->quality, $degrade);
    }
}
