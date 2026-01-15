<?php

namespace App\Filament\Widgets;

use App\Models\Projets;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountProjetWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    public function getColumnSpan(): int|array
    {
        return [
            'md' => 4,
            'xl' => 4,
        ];
    }


    protected function getStats(): array
    {
        return [
            Stat::make('Nombre de projets', Projets::count())
                ->description('Compteur du nombre de projets créés')
                ->descriptionIcon(Heroicon::ChartBar)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->icon(Heroicon::BuildingLibrary)
                ->color('info'),
        ];
    }
}
