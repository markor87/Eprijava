<?php

namespace App\Filament\Resources\Places\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlaceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Место')
                ->inlineLabel()
                ->schema([
                    TextInput::make('name')
                        ->label('Назив места')
                        ->required(),
                    TextInput::make('municipality_name')
                        ->label('Општина / град')
                        ->required(),
                ]),
        ]);
    }
}
