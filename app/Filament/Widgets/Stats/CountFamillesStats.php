<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Familles;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountFamillesStats implements StatsInterface
{
    public static function make(): Stat {
        return Stat::make('Nombre de familles', Familles::count())
            ->description('Compteur du nombre de familles créées')
            ->descriptionIcon(Heroicon::ArrowTrendingUp)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->icon(Heroicon::AcademicCap)
            ->color('warning');
    }
}
