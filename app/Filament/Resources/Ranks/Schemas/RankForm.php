<?php

namespace App\Filament\Resources\Ranks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Звање')
                ->inlineLabel()
                ->schema([
                    TextInput::make('name')
                        ->label('Назив звања')
                        ->required(),
                ]),
        ]);
    }
}
