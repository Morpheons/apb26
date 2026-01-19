<?php

namespace App\Filament\Widgets\Stats;

use Filament\Widgets\StatsOverviewWidget\Stat;

interface StatsInterface
{
    public static function make(): Stat;
}
