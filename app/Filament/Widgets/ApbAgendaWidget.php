<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\Filament\Actions\ViewAction; // ✅ IMPORTANT (pas Filament\Actions\ViewAction)
use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ApbAgendaWidget extends CalendarWidget
{
    protected bool $eventClickEnabled = true;
    protected static ?int $sort = 5;
    // Quand on clique un event, Guava va monter cette action (nom = action name)
    protected ?string $defaultEventClickAction = 'viewAppointment';
    protected function getColumns(): int
    {
        return 1;
    }
    protected function getEvents(FetchInfo $info): Collection|array
    {
        return Appointment::query()
            ->whereBetween('starts_at', [$info->start, $info->end])
            ->get()
            ->map(fn (Appointment $appointment) => CalendarEvent::make($appointment) // ✅ sets model + key
            ->title($appointment->title)
                ->start($appointment->starts_at)
                ->end($appointment->ends_at)
                // optionnel : tu peux forcer l’action par event, sinon defaultEventClickAction suffit
                ->action('viewAppointment')
            )
            ->all();
    }


    public function viewAppointmentAction(): ViewAction
    {
        return ViewAction::make('viewAppointment')
            ->model(Appointment::class) // ✅ Guava aime bien savoir le model

            ->modalHeading('Détails du Rendez-vous')
            ->modalWidth('5xl')
            ->modalFooterActions([])
            ->modalContent(fn ($record): View => view('filament.widgets.appointment.modal', compact('record')));
    }
}
