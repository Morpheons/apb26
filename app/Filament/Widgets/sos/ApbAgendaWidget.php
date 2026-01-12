<?php

namespace App\Filament\Widgets\sos;

use App\Models\Appointment;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
//use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\Section;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\ValueObjects\FetchInfo;
use Guava\Calendar\ValueObjects\EventClickInfo;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\ViewEntry;

class ApbAgendaWidget extends CalendarWidget
{
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
            )
            ->toArray();
    }

    public function onEventClick(EventClickInfo $info, Model $record, ?string $action = null): void
    {
        $this->mountAction('view', [
            'record' => $record->id,
        ]);
    }

    protected function actions(): array
    {
        return [
            ViewAction::make('view')
                ->record(fn (array $arguments) => Appointment::find($arguments['record'] ?? null))
                ->modalHeading('Détails du Rendez-vous')
                ->modalWidth('5xl')
                ->modalFooterActions([])
                ->infolist(fn (Infolist $infolist) => $infolist
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Objet')
                                    ->weight('bold'),
                                TextEntry::make('starts_at')
                                    ->label('Date et Heure')
                                    ->dateTime('d F Y H:i'),
                                TextEntry::make('start_address')
                                    ->label('Départ')
                                    ->placeholder('Position actuelle'),
                                TextEntry::make('address')
                                    ->label('Destination'),

                                ViewEntry::make('map_route')
                                    ->label('Itinéraire')
                                    ->view('apb-agenda')
                                    ->columnSpanFull(),

                                TextEntry::make('notes')
                                    ->label('Notes')
                                    ->columnSpanFull()
                                    ->markdown(),
                            ])
                    ])
                ),
        ];
    }
}
