<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Updater\ItemUpdaterResolver;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {}

    public function updateQuality(): void
    {
        $resolver = new ItemUpdaterResolver();

        foreach ($this->items as $item) {
            $resolver->resolve($item->name)->update($item);
        }
    }
}
