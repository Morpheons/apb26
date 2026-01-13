<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class AutocompleteAdresse extends Field
{
    protected string $view = 'filament.forms.components.autocomplete-adresse';

    protected string $showedKey = 'properties.label';

    public function showedKey(string $path): static
    {
        $this->showedKey = $path;

        return $this;
    }

    public function getShowedKey(): string
    {
        return $this->showedKey;
    }
}
