<?php

namespace App\Filament\Resources\RequiredProofs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RequiredProofForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Доказ уз пријаву')
                ->schema([
                    TextInput::make('proof_description')
                        ->label('Опис доказа')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('proof_type')
                        ->label('Врста доказа')
                        ->options([
                            'official_records' => 'Орган прибавља из службених евиденција',
                            'personal'         => 'Кандидат лично доставља',
                        ])
                        ->required(),
                ])
                ->columns(2),
        ]);
    }
}
