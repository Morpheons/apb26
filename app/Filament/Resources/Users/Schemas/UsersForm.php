<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('👤 Informations personnelles')
                    ->description('Renseignez les informations de base de l\'utilisateur')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Jean')
                            ->prefixIcon('heroicon-o-user')
                            ->autocomplete('name')
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Dupont')
                            ->prefixIcon('heroicon-o-user')
                            ->autocomplete('name')
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->maxLength(255)
                            ->placeholder('exemple@domaine.com')
                            ->prefixIcon('heroicon-o-envelope')
                            ->autocomplete('email')
                            ->columnSpanFull(),

                        FileUpload::make('avatar_url')
                            ->label('Photo de profil')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->disk('public')
                            ->directory('avatars')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->placeholder('Cliquez pour ajouter une photo'),
                    ]),


                Section::make('🔐 Paramètres du compte')
                    ->description('Définissez les permissions et paramètres d\'accès')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(2)
                    ->schema([
                        Select::make('roles')
                            ->label('Rôles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-o-shield-check')
                            ->searchable()
                            ->optionsLimit(10)
                            ->helperText('Sélectionnez un ou plusieurs rôles pour cet utilisateur'),

                        Toggle::make('is_actif')
                            ->inline(false)
                            ->label('Compte actif')
                            ->helperText('L\'utilisateur pourra se connecter si activé')
                            ->default(true)
                            ->onIcon('heroicon-s-check')
                            ->offIcon('heroicon-s-x-mark')
                            ->onColor('success')
                            ->offColor('danger'),

                    ]),
            ]);
    }
}
