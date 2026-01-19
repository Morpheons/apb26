<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Appointment;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountRdvStats implements StatsInterface
{

    public static function make(): Stat
    {

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $rdvThisWeek = Appointment::query()
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->count();
        return Stat::make('Nb de RDV cette semaine', $rdvThisWeek)
            ->description('Compteur du nombre de RDV cette semaine')
            ->descriptionIcon(Heroicon::CalendarDateRange)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->icon(Heroicon::Calendar)
            ->color('danger');
    }
}
