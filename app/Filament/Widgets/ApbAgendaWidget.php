<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Actions\ViewAction;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class ApbAgendaWidget extends CalendarWidget
{
    // On force ces propriétés au niveau le plus bas
    protected bool $clickable = true;
    protected bool $eventClickEnabled = true;

    public function getEvents(FetchInfo $info): Collection|array
    {
        return Appointment::query()
            ->whereBetween('starts_at', [$info->start, $info->end])
            ->get()
            ->map(fn (Appointment $appointment) =>
            CalendarEvent::make($appointment)
                ->title($appointment->title)
                ->start($appointment->starts_at)
                ->end($appointment->starts_at->copy()->addHour())
                ->key($appointment->id)
                ->extendedProps(['id' => $appointment->id])
            )
            ->toArray();
    }

    public function getOptions(): array
    {
        return [
            // On force l'affichage et l'interaction
            'eventDisplay' => 'block',
            'eventInteractive' => true,
            'eventClick' => "function(info) {
                // On force l'arrêt de la propagation pour éviter que FullCalendar ne bloque le clic
                info.jsEvent.preventDefault();
                @this.mountAction('viewAppointment', { record: info.event.id || info.event.extendedProps.id });
            }",
        ];
    }

    // INJECTION CSS PRIORITAIRE
    protected function getViewData(): array
    {
        return [
            'header' => '
                <style>
                    /* On cible toutes les classes possibles de FullCalendar */
                    .fc-event, .fc-event-main, .fc-event-title, .fc-daygrid-event {
                        cursor: pointer !important;
                        pointer-events: auto !important;
                        display: block !important;
                    }
                    .fc-event:hover {
                        opacity: 0.8 !important;
                        background-color: rgba(255,255,255,0.1) !important;
                    }
                </style>
            ',
        ];
    }

    protected function actions(): array
    {
        return [
            ViewAction::make('viewAppointment')
                ->record(fn (array $arguments) => Appointment::find($arguments['record'] ?? null))
                ->modalHeading('Détails du Rendez-vous')
                ->modalWidth('5xl')
                ->modalFooterActions([])
                ->modalContent(fn ($record): View => view('apb-modal-viewer', [
                    'appointment' => $record
                ])),
        ];
    }
}
