<?php

namespace App\Filament\Resources\ExamTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExamTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Врста испита')
                ->schema([
                    TextInput::make('name')
                        ->label('Назив врсте испита')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('sort_order')
                        ->label('Редослед')
                        ->numeric()
                        ->default(0)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
