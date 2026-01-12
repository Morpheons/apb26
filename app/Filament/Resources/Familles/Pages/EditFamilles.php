<?php

namespace App\Filament\Resources\Familles\Pages;

use App\Filament\Resources\Familles\FamillesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFamilles extends EditRecord
{
    protected static string $resource = FamillesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
