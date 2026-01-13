<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Filament\Forms\Components\AutocompleteAdresse;
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
        $from = AutocompleteAdresse::make('locations_from')
            ->label('Adresse de départ')
            ->showedKey('properties.label')
            ->required();

        $to = AutocompleteAdresse::make('locations_to')
            ->label('Adresse d’arrivée')
            ->showedKey('properties.label')
            ->required();

        return $schema
            ->components([
                Section::make('Détails du Rendez-vous')->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                            TextInput::make('title')
                                ->label('Objet')
                                ->required()
                                ->columnSpanFull(),

                            DateTimePicker::make('starts_at')
                                ->label('Date et Heure début')
                                ->required()
                                ->native(false),

DateTimePicker::make('ends_at')
                                ->label('Date et Heure fin')
                                ->required()
                                ->native(false),




                            Textarea::make('description')
                                ->label('Notes de préparation')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ,
                    ])->columns(1),
                Section::make('Coordonnés GPS')->columnSpanFull()->schema([
                    Grid::make()->schema([$from, $to]),
                    ViewField::make('map')
                        ->view('filament.forms.views.mapbox-route')
                        ->viewData([
                            'fromStatePath' => 'data.locations_from',
                            'toStatePath'   => 'data.locations_to',
                        ])
                        ->dehydrated(false)
                        ->columnSpanFull()

//        ViewField::make('map_preview')
//                                ->view('filament.widgets.apb-agenda')
//                                ->columnSpanFull(),
                ])
            ]);
    }
}
