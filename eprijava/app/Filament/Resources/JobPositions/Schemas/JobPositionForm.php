<?php

namespace App\Filament\Resources\JobPositions\Schemas;

use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Радно место')
                ->inlineLabel()
                ->schema([
                    TextInput::make('position_name')
                        ->label('Назив радног места')
                        ->rule(new SerbianCyrillic())
                        ->required(),
                ]),
        ]);
    }
}
