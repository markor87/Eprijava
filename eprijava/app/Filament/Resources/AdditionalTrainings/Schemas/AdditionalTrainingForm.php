<?php

namespace App\Filament\Resources\AdditionalTrainings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdditionalTrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Додатна обука')
                ->schema([
                    TextInput::make('training_name')
                        ->label('Обука / страни језик')
                        ->required(),
                    TextInput::make('institution_name')
                        ->label('Назив институције')
                        ->required(),
                    TextInput::make('location_or_level')
                        ->label('Место одржавања обуке / ниво знања')
                        ->required(),
                    TextInput::make('year')
                        ->label('Година')
                        ->numeric(),
                ])
                ->columns(2),
        ]);
    }
}
