<?php

namespace App\Filament\Resources\Familles\Schemas;


use App\Filament\Forms\Components\Input\SlugInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class FamillesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                Step::make('Informations')
                    ->label(__('Informations'))
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('titre')
                                ->label(__('Titre famille'))
                                ->required()
                                ->columnSpan(12),

                            Toggle::make('is_actif')
                                ->label(__('Activer'))
                                ->inline(false)
                                ->onColor('success')
                                ->offColor('danger')
                                ->default(false)
                                ->required()
                                ->columnSpan(12),

                            SlugInput::make('slug')
                                ->from('titre')
                                ->columnSpan(12),

                            TextInput::make('labeltext')
                                ->label(__('Rapide descriptif'))
                                ->nullable()
                                ->columnSpan(12),

                            RichEditor::make('description')
                                ->label(__('Texte de description'))
                                ->toolbarButtons([
                                    ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                    ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                    ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                                    ['undo', 'redo'],
                                ])
                                ->floatingToolbars([
                                    'paragraph' => [
                                        'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                                    ],
                                    'heading' => [
                                        'h1', 'h2', 'h3',
                                    ],
                                    'table' => [
                                        'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                                        'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                                        'tableMergeCells', 'tableSplitCell',
                                        'tableToggleHeaderRow', 'tableToggleHeaderCell',
                                        'tableDelete',
                                    ],
                                ])
                                ->nullable()
                                ->columnSpan(12),
                        ]),
                    ]),

                Step::make('Images')
                    ->label(__('Gestion des images'))
                    ->schema([
                        Grid::make(12)->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('familles/img')
                                ->visibility('public')
                                ->image()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->placeholder('Cliquez pour ajouter une photo')
                                ->imagePreviewHeight(300) // 👈 hauteur du preview
                                ->panelAspectRatio('16:9') // 👈 ratio du cadre
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    null,
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ])
                                ->imageEditorViewportWidth(1920)
                                ->imageEditorViewportHeight(1080)
                                ->columnSpan(6),

                            FileUpload::make('fond')
                                ->disk('public')
                                ->directory('familles/fond')
                                ->visibility('public')
                                ->image()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->placeholder('Cliquez pour ajouter une photo')
                                ->imagePreviewHeight(300) // 👈 hauteur du preview
                                ->panelAspectRatio('16:9') // 👈 ratio du cadre
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    null,
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ])
                                ->imageEditorViewportWidth(1920)
                                ->imageEditorViewportHeight(1080)
                                ->columnSpan(6),
                        ]),
                    ]),
            ])->columnSpanFull(),
        ]);
    }
}
