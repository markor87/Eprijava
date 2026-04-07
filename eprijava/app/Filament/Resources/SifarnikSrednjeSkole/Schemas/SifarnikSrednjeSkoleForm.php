<?php

namespace App\Filament\Resources\SifarnikSrednjeSkole\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SifarnikSrednjeSkoleForm
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
