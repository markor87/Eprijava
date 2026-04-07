<?php

namespace App\Filament\Resources\HighSchoolEducations\Schemas;

use App\Models\SifarnikSrednjeSkole;
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
                    Select::make('institution_name')
                        ->label('Назив школе')
                        ->options(
                            SifarnikSrednjeSkole::orderBy('name')->get()
                                ->mapWithKeys(fn($s) => [$s->id => $s->name . ' — ' . $s->city])
                        )
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $school = $state ? SifarnikSrednjeSkole::find($state) : null;
                            $set('institution_location', $school?->id);
                        }),
                    Select::make('institution_location')
                        ->label('Седиште школе')
                        ->options(SifarnikSrednjeSkole::orderBy('city')->pluck('city', 'id'))
                        ->disabled()
                        ->dehydrated(true),
                    Select::make('duration')
                        ->label('Трајање')
                        ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4']),
                    TextInput::make('direction')
                        ->label('Смер')
                        ->rule(new \App\Rules\SerbianCyrillic()),
                    TextInput::make('occupation')
                        ->label('Занимање')
                        ->rule(new \App\Rules\SerbianCyrillic())
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
