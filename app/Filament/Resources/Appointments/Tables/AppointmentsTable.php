<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;



class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Objet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label('Fin')
                    ->dateTime('H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('address')
                    ->label('Adresse')
                    ->limit(30)
                    ->tooltip(fn ($state) => $state),
            ])
            ->actions([
                // Action personnalisée pour l'itinéraire direct depuis la liste
                Action::make('itineraire')
                    ->label('Itinéraire')
                    ->icon('heroicon-m-map-pin')
                    ->color('success')
                    ->url(fn ($record) => $record->address
                        ? "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($record->address)
                        : null, true),

                EditAction::make()
                    ->color('success')
                    ->icon(Heroicon::PencilSquare)
                    ->hiddenLabel(),
                DeleteAction::make()
                    ->color('danger')
                    ->icon(Heroicon::Trash)
                    ->hiddenLabel(),
            ])
            ->filters([
                // Vous pourrez ajouter des filtres par date ici plus tard
            ])
            ->bulkActions([
                // Actions groupées si besoin
            ]);
    }
}
