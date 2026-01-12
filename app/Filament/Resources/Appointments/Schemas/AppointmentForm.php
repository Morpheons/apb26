<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détails du Rendez-vous')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                            TextInput::make('title')
                                ->label('Objet')
                                ->required()
                                ->columnSpanFull(),

                            DateTimePicker::make('starts_at')
                                ->label('Date et Heure')
                                ->required()
                                ->native(false),

                            TextInput::make('start_address')
                                ->label('Départ (Laisser vide pour position actuelle)')
                                ->placeholder('Ex: 12 Rue de la Mer, Plouider')
                                ->live(onBlur: true),

                            TextInput::make('address')
                                ->label('Destination (Lieu du RDV)')
                                ->required()
                                ->live(onBlur: true)
                                ->suffixAction(
                                    Action::make('itineraire_externe')
                                        ->icon('heroicon-m-map')
                                        ->color('info')
                                        ->url(fn ($get) => $get('address')
                                            ? "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($get('address')) . "&origin=" . urlencode($get('start_address') ?? '')
                                            : null, true)
                                ),

                            ViewField::make('map_preview')
                                ->view('filament.widgets.apb-agenda')
                                ->columnSpanFull(),

                            Textarea::make('description')
                                ->label('Notes de préparation')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    ])->columns(1)
            ]);
    }
}
