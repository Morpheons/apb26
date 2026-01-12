<?php

namespace App\Filament\Resources\Projets;

use App\Filament\Resources\Projets\Pages\CreateProjets;
use App\Filament\Resources\Projets\Pages\EditProjets;
use App\Filament\Resources\Projets\Pages\ListProjets;
use App\Filament\Resources\Projets\Schemas\ProjetsForm;
use App\Filament\Resources\Projets\Tables\ProjetsTable;
use App\Models\Projets;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjetsResource extends Resource
{
    protected static ?string $model = Projets::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Photo;
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'Projets';

    public static function form(Schema $schema): Schema
    {
        return ProjetsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjetsTable::configure($table);
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
            'index' => ListProjets::route('/'),
            'create' => CreateProjets::route('/create'),
            'edit' => EditProjets::route('/{record}/edit'),
        ];
    }
}
