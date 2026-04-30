<?php

namespace App\Filament\Resources\GovernmentBodies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GovernmentBodyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Државни орган')
                ->schema([
                    TextInput::make('name')
                        ->label('Назив органа')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('government_body_code')
                        ->label('Шифра органа')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
