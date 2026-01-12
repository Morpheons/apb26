<?php

namespace App\Filament\Forms\Components\Input;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class SlugInput extends TextInput
{
    protected string $sourceField;

    public static function make(string|null $name = 'slug'): static
    {
        return parent::make($name)
            ->label('Slug')
            ->required()
            ->unique(ignoreRecord: true);
    }

    public function from(string $field): static
    {
        $this->sourceField = $field;

        return $this
            ->live(onBlur: true)
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                if (! $state) {
                    $set($this->getName(), Str::slug($get($this->sourceField)));
                }
            });
    }
}
