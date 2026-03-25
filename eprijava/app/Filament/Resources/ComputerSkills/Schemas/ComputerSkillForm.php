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
                        ->required(),
                    TextInput::make('word_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric(),
                    Select::make('word_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    FileUpload::make('word_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('public')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/word'),
                ]),

            Section::make('Microsoft Excel')
                ->inlineLabel()
                ->schema([
                    Select::make('excel_has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    TextInput::make('excel_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric(),
                    Select::make('excel_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    FileUpload::make('excel_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('public')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/excel'),
                ]),

            Section::make('Internet')
                ->inlineLabel()
                ->schema([
                    Select::make('internet_has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    TextInput::make('internet_certificate_year')
                        ->label('Година стицања сертификата / другог доказа')
                        ->numeric(),
                    Select::make('internet_exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања дигиталне писмености')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    FileUpload::make('internet_certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('public')
                        ->directory(fn() => 'computer-skill-attachments/' . auth()->id() . '/internet'),
                ]),
        ]);
    }
}
