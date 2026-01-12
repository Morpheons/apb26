<?php

namespace App\Filament\Resources\Familles;

use App\Filament\Resources\Familles\Pages\CreateFamilles;
use App\Filament\Resources\Familles\Pages\EditFamilles;
use App\Filament\Resources\Familles\Pages\ListFamilles;
use App\Filament\Resources\Familles\Schemas\FamillesForm;
use App\Filament\Resources\Familles\Tables\FamillesTable;
use App\Models\Familles;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class FamillesResource extends Resource
{
    protected static ?string $model = Familles::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?int $navigationSort = 2;
//    protected static ?string $recordTitleAttribute = 'Familles';
    public static function getNavigationGroup(): ?string
    {
        return __('Paramètres');
    }
    public static function getNavigationLabel(): string
    {
        return __('Familles');
    }

    public static function form(Schema $schema): Schema
    {
        return FamillesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FamillesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFamilles::route('/'),
            'create' => CreateFamilles::route('/create'),
            'edit' => EditFamilles::route('/{record}/edit'),
        ];
    }
}
