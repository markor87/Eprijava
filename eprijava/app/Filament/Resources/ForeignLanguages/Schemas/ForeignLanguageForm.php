<?php

namespace App\Filament\Resources\ForeignLanguages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ForeignLanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Страни језик')
                ->schema([
                    TextInput::make('language_name')
                        ->label('Назив страног језика')
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
