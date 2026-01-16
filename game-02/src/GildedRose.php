<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            // Sulfuras nunca cambia
            if ($this->isSulfuras($item)) {
                continue;
            }

            // Actualizar quality según tipo
            if ($this->isBackstagePass($item)) {
                $this->updateBackstagePass($item);
            } elseif ($this->isAgedBrie($item)) {
                $this->increaseQuality($item, $this->isExpired($item) ? 2 : 1);
            } else {
                // Normal y Conjured degradan
                $degrade = $this->isConjured($item) ? 2 : 1;
                $this->decreaseQuality($item, $this->isExpired($item) ? $degrade * 2 : $degrade);
            }

            // Fin del día: baja sellIn (excepto Sulfuras, ya retornamos arriba)
            $item->sellIn -= 1;
        }
    }

    private function updateBackstagePass(Item $item): void
    {
        // Si ya expiró: quality = 0
        if ($this->isExpired($item)) {
            $item->quality = 0;
            return;
        }

        // Aumenta 1 normalmente, 2 si <=10, 3 si <=5
        $increase = 1;

        if ($item->sellIn <= 10) {
            $increase = 2;
        }

        if ($item->sellIn <= 5) {
            $increase = 3;
        }

        $this->increaseQuality($item, $increase);
    }

    private function isExpired(Item $item): bool
    {
        return $item->sellIn <= 0;
    }

    private function increaseQuality(Item $item, int $by = 1): void
    {
        $item->quality = min(50, $item->quality + $by);
    }

    private function decreaseQuality(Item $item, int $by = 1): void
    {
        $item->quality = max(0, $item->quality - $by);
    }

    private function isAgedBrie(Item $item): bool
    {
        return $item->name === 'Aged Brie';
    }

    private function isSulfuras(Item $item): bool
    {
        return $item->name === 'Sulfuras, Hand of Ragnaros';
    }

    private function isBackstagePass(Item $item): bool
    {
        return $item->name === 'Backstage passes to a TAFKAL80ETC concert';
    }

    private function isConjured(Item $item): bool
    {
        // La kata suele venir como "Conjured Mana Cake" o similares
        return str_starts_with($item->name, 'Conjured');
    }
}
