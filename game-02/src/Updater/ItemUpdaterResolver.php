<?php

declare(strict_types=1);

namespace GildedRose\Updater;

final class ItemUpdaterResolver
{
    public function resolve(string $name): ItemUpdater
    {
        if ($name === 'Aged Brie') {
            return new AgedBrieUpdater();
        }

        if ($name === 'Backstage passes to a TAFKAL80ETC concert') {
            return new BackstagePassUpdater();
        }

        if ($name === 'Sulfuras, Hand of Ragnaros') {
            return new SulfurasUpdater();
        }

        // "Conjured ..." -> ConjuredUpdater
        if ($this->startsWith($name, 'Conjured')) {
            return new ConjuredUpdater();
        }

        return new NormalItemUpdater();
    }

    private function startsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}
