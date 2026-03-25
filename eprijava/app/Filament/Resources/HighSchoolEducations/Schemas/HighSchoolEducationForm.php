<?php

namespace App\Filament\Resources\HighSchoolEducations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HighSchoolEducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Средња школа / Гимназија')
                ->inlineLabel()
                ->schema([
                    TextInput::make('institution_name')
                        ->label('Назив школе'),
                    TextInput::make('institution_location')
                        ->label('Седиште школе'),
                    TextInput::make('duration')
                        ->label('Трајање'),
                    TextInput::make('direction')
                        ->label('Смер'),
                    TextInput::make('occupation')
                        ->label('Занимање')
                        ->helperText('Не попуњавају кандидати који су завршили гимназију'),
                    TextInput::make('graduation_year')
                        ->label('Година завршетка')
                        ->numeric()
                        ->minValue(1950)
                        ->maxValue(2099),
                ]),
        ]);
    }
}
