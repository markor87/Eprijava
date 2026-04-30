<?php

namespace App\Filament\Resources\NationalMinorities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NationalMinorityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Национална мањина')
                ->schema([
                    TextInput::make('minority_name')
                        ->label('Назив националне мањине')
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
