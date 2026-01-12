<?php

namespace App\Filament\Resources\Projets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titre')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_actif')
                    ->label(__('Activé'))
                    ->boolean(),
                TextColumn::make('famille.titre')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('labeltext')
                    ->label(__('Info rapide'))
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->imageSize(40),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('famille.titre')
                    ->relationship('famille', 'titre', hasEmptyOption: true)
                    ->searchable()
                    ->preload()
            ],layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()
                    ->color('success')
                    ->icon(Heroicon::PencilSquare)
                    ->hiddenLabel(),
                DeleteAction::make()
                    ->color('danger')
                    ->icon(Heroicon::Trash)
                    ->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
