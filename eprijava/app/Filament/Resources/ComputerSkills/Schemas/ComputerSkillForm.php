<?php

namespace App\Filament\Resources\ComputerSkills\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComputerSkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Microsoft Word')
                ->inlineLabel()
                ->schema([
                    Select::make('word_has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($state, $set) => $state == 0 ? $set('word_exemption_requested', 0) : null),
                    TextInput::make('word_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric()
                        ->hidden(fn($get) => !$get('word_has_certificate'))
                        ->required(fn($get) => (bool) $get('word_has_certificate')),
                    Select::make('word_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->disabled(fn($get) => !$get('word_has_certificate'))
                        ->dehydrated()
                        ->live(),
                    FileUpload::make('word_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('local')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/word')
                        ->downloadable()
                        ->previewable(false)
                        ->hidden(fn($get) => !$get('word_exemption_requested'))
                        ->required(fn($get) => (bool) $get('word_exemption_requested')),
                ]),

            Section::make('Microsoft Excel')
                ->inlineLabel()
                ->schema([
                    Select::make('excel_has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($state, $set) => $state == 0 ? $set('excel_exemption_requested', 0) : null),
                    TextInput::make('excel_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric()
                        ->hidden(fn($get) => !$get('excel_has_certificate'))
                        ->required(fn($get) => (bool) $get('excel_has_certificate')),
                    Select::make('excel_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->disabled(fn($get) => !$get('excel_has_certificate'))
                        ->dehydrated()
                        ->live(),
                    FileUpload::make('excel_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('local')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/excel')
                        ->downloadable()
                        ->previewable(false)
                        ->hidden(fn($get) => !$get('excel_exemption_requested'))
                        ->required(fn($get) => (bool) $get('excel_exemption_requested')),
                ]),

            Section::make('Internet')
                ->inlineLabel()
                ->schema([
                    Select::make('internet_has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($state, $set) => $state == 0 ? $set('internet_exemption_requested', 0) : null),
                    TextInput::make('internet_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric()
                        ->hidden(fn($get) => !$get('internet_has_certificate'))
                        ->required(fn($get) => (bool) $get('internet_has_certificate')),
                    Select::make('internet_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->disabled(fn($get) => !$get('internet_has_certificate'))
                        ->dehydrated()
                        ->live(),
                    FileUpload::make('internet_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('local')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/internet')
                        ->downloadable()
                        ->previewable(false)
                        ->hidden(fn($get) => !$get('internet_exemption_requested'))
                        ->required(fn($get) => (bool) $get('internet_exemption_requested')),
                ]),
        ]);
    }
}
