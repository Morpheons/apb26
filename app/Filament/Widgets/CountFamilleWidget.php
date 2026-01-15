<?php

namespace App\Filament\Widgets;

use App\Models\Familles;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountFamilleWidget extends BaseWidget
{
    protected static ?int $sort = 2;

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
            Stat::make('Nombre de familles', Familles::count())
                ->description('Compteur du nombre de familles créées')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->icon(Heroicon::AcademicCap)
                ->color('warning'),
        ];
    }
}
