<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Familles;
use App\Models\Projets;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountProjetsStats implements StatsInterface
{
    public static function make(): Stat {
       return Stat::make('Nombre de projets', Projets::count())
            ->description('Compteur du nombre de projets créés')
            ->descriptionIcon(Heroicon::ChartBar)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->icon(Heroicon::BuildingLibrary)
            ->color('info');
    }
}
