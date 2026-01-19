<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Item;

interface ItemUpdater
{
    public function update(Item $item): void;
}
