<?php

namespace App\Filament\Pages;

use App\Models\AdminSetting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section; // On garde Section du Schema
use Filament\Schemas\Schema; // On utilise bien Schema pour Filament 4
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use BackedEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?int $navigationSort = 1;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected string $view = 'filament.pages.manage-settings';

    public static function getNavigationGroup(): ?string { return __('Paramètres'); }
    public static function getNavigationLabel(): string { return __('Thème Dashboard'); }
    protected static ?string $title = 'Personnalisation du thème';

    public ?array $data = [];

    public static function getPresets(): array
    {
        return [
            'default' => [
                'label' => 'Défaut',
                'primary_color' => '#6366f1',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'danger_color' => '#ef4444',
                'info_color' => '#3b82f6',
                'gray_color' => '#27272a',
                'sidebar_color' => '#1e1b4b',
                'background_color' => '#0f172a',
            ],
            'nuit_sombre' => [
                'label' => 'Nuit Sombre',
                'primary_color' => '#f59e0b',
                'success_color' => '#10b981',
                'warning_color' => '#f97316',
                'danger_color' => '#ef4444',
                'info_color' => '#27272a',
                'gray_color' => '#09090b',
                'sidebar_color' => '#000000',
                'background_color' => '#000000',
            ],
            'ocean' => [
                'label' => 'Océan',
                'primary_color' => '#06b6d4',
                'success_color' => '#14b8a6',
                'warning_color' => '#f59e0b',
                'danger_color' => '#f43f5e',
                'info_color' => '#3b82f6',
                'gray_color' => '#070f1a',
                'sidebar_color' => '#020617',
                'background_color' => '#020617',
            ],
            'forest' => [
                'label' => 'Forêt Émeraude',
                'primary_color' => '#10b981', // Vert émeraude
                'success_color' => '#059669',
                'warning_color' => '#fbbf24',
                'danger_color' => '#e11d48',
                'info_color' => '#34d399',
                'gray_color' => '#121a16',    // Gris teinté de vert
                'sidebar_color' => '#06110d', // Noir forestier
                'background_color' => '#040d0a',
            ],
            'cyberpunk' => [
                'label' => 'Néon Cyber',
                'primary_color' => '#d946ef', // Fuchsia néon
                'success_color' => '#22d3ee', // Cyan
                'warning_color' => '#facc15',
                'danger_color' => '#ff0055',
                'info_color' => '#818cf8',
                'gray_color' => '#1e1b4b',    // Violet très sombre
                'sidebar_color' => '#0f172a',
                'background_color' => '#020617',
            ],
            'crimson' => [
                'label' => 'Rouge Crimson',
                'primary_color' => '#e11d48', // Rouge vif
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'danger_color' => '#991b1b',
                'info_color' => '#fb7185',
                'gray_color' => '#1c1917',    // Gris pierre
                'sidebar_color' => '#0c0a09',
                'background_color' => '#0c0a09',
            ],
            'gold_luxury' => [
                'label' => 'Luxe Or',
                'primary_color' => '#d4af37', // Or
                'success_color' => '#166534',
                'warning_color' => '#b45309',
                'danger_color' => '#991b1b',
                'info_color' => '#a8a29e',
                'gray_color' => '#1a1a1a',    // Gris anthracite pur
                'sidebar_color' => '#000000',
                'background_color' => '#050505',
            ],
            'sunset' => [
                'label' => 'Coucher de Soleil',
                'primary_color' => '#f97316', // Orange sunset
                'success_color' => '#84cc16',
                'warning_color' => '#fbbf24',
                'danger_color' => '#dc2626',
                'info_color' => '#f472b6',
                'gray_color' => '#1e1b4b',    // Fond légèrement bleuté
                'sidebar_color' => '#0c0a09',
                'background_color' => '#0c0a09',
            ],
        ];
    }

    public function mount(): void
    {
        $settings = AdminSetting::current();
        $this->form->fill($settings->toArray());
    }

    /**
     * Correction Filament 4 : On utilise Schema $schema
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Identité visuelle')
                    ->schema([
                        TextInput::make('brand_name')->label('Nom du Dashboard')->required(),
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('admin'),
                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('admin'),
                    ])->columns(2),

                Section::make('Thèmes et Présets')
                    ->schema([
                        Select::make('preset')
                            ->label('Sélectionner un préset')
                            ->options(collect(static::getPresets())->mapWithKeys(fn($p, $k) => [$k => $p['label'] ?? ucfirst($k)]))
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $presets = static::getPresets();
                                if ($state && isset($presets[$state])) {
                                    foreach ($presets[$state] as $key => $value) {
                                        if ($key !== 'label') { $set($key, $value); }
                                    }
                                }
                            }),
                    ]),

                Section::make('Palette de couleurs')
                    ->schema([
                        ColorPicker::make('primary_color')->label('Couleur primaire')->required(),
                        ColorPicker::make('success_color')->label('Couleur succès')->required(),
                        ColorPicker::make('warning_color')->label('Couleur avertissement')->required(),
                        ColorPicker::make('danger_color')->label('Couleur danger')->required(),
                        ColorPicker::make('info_color')->label('Couleur info')->required(),
                        ColorPicker::make('gray_color')->label('Couleur gris (UI)')->required(),
                        ColorPicker::make('sidebar_color')->label('Couleur du menu latéral'),
                        ColorPicker::make('background_color')->label('Couleur de fond'),
                    ])->columns(3),

                Section::make('Configuration de l\'interface')
                    ->schema([
                        Select::make('font_family')
                            ->label('Police de caractères')
                            ->options(['Inter' => 'Inter', 'Roboto' => 'Roboto'])
                            ->required(),
                        Toggle::make('show_breadcrumbs')->label('Afficher le fil d\'Ariane')->default(true),
                        Toggle::make('is_dark_mode_enabled')->label('Activer le mode sombre')->default(true),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            $settings = AdminSetting::current();
            $settings->update($data);

            Notification::make()->title('Paramètres enregistrés')->success()->send();
            $this->redirect(static::getUrl(), navigate: false);
        } catch (\Exception $e) {
            Notification::make()->title('Erreur')->danger()->send();
        }
    }
}
