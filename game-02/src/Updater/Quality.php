<?php

declare(strict_types=1);

namespace GildedRose\Updater;

final class Quality
{
    public const MIN = 0;
    public const MAX = 50;
    public const SULFURAS = 80;

    public static function increase(int $quality, int $by = 1): int
    {
        return min(self::MAX, $quality + $by);
    }

    public static function decrease(int $quality, int $by = 1): int
    {
        return max(self::MIN, $quality - $by);
    }
}
