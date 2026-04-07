<?php

namespace App\Filament\Resources\HighSchools\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HighSchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Средња школа')
                ->inlineLabel()
                ->schema([
                    TextInput::make('name')
                        ->label('Назив')
                        ->required(),
                    TextInput::make('city')
                        ->label('Место')
                        ->required(),
                ]),
        ]);
    }
}
