<?php

namespace App\Filament\Resources\AcademicTitles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AcademicTitleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Шифарник поља, области и звања')
                ->inlineLabel()
                ->schema([
                    TextInput::make('educational_scientific_field')
                        ->label('Образовно-научно поље')
                        ->required(),
                    TextInput::make('scientific_professional_area')
                        ->label('Научно-стручна област')
                        ->required(),
                    TextInput::make('title')
                        ->label('Звање')
                        ->required(),
                ]),
        ]);
    }
}
