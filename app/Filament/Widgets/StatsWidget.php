<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Stats\CountFamillesStats;
use App\Filament\Widgets\Stats\CountProjetsStats;
use App\Filament\Widgets\Stats\CountRdvStats;
use App\Models\Familles;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | array | null $columns = 2;


    protected function getStats(): array
    {
        $familleStats = CountFamillesStats::make();
        $projetStats = CountProjetsStats::make();
        $countRdvStats = CountRdvStats::make();
        return [
            $familleStats, $projetStats, $countRdvStats,
        ];
    }
}
