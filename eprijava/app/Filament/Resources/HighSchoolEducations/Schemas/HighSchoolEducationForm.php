<?php

namespace App\Filament\Resources\HighSchoolEducations\Schemas;

use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\Select;
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
                        ->label('Назив школе')
                        ->rule(new SerbianCyrillic()),
                    TextInput::make('institution_location')
                        ->label('Седиште школе')
                        ->rule(new SerbianCyrillic()),
                    Select::make('duration')
                        ->label('Трајање')
                        ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4']),
                    TextInput::make('direction')
                        ->label('Смер')
                        ->rule(new SerbianCyrillic()),
                    TextInput::make('occupation')
                        ->label('Занимање')
                        ->rule(new SerbianCyrillic())
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
