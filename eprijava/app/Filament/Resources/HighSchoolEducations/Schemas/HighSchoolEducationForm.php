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
                ->schema([
                    TextInput::make('institution_name')
                        ->label('Назив школе')
                        ->columnSpanFull(),
                    TextInput::make('institution_location')
                        ->label('Седиште школе'),
                    TextInput::make('duration')
                        ->label('Трајање'),
                    TextInput::make('direction')
                        ->label('Смер'),
                    TextInput::make('occupation')
                        ->label('Занимање')
                        ->hint('Не попуњавају кандидати који су завршили гимназију')
                        ->columnSpanFull(),
                    TextInput::make('graduation_year')
                        ->label('Година завршетка')
                        ->numeric()
                        ->minValue(1950)
                        ->maxValue(2099),
                ])
                ->columns(2),
        ]);
    }
}
