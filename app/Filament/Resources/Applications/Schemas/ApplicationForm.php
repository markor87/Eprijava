<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('job_position_id'),
            Hidden::make('competition_id'),
            Hidden::make('government_body_id'),

            Section::make('Радно место')
                ->inlineLabel()
                ->schema([
                    TextInput::make('rank_name')
                        ->label('Звање')
                        ->readOnly(),
                    TextInput::make('org_unit_path')
                        ->label('Путања орг. јединице')
                        ->readOnly(),
                ]),

            Section::make('Подаци кандидата')
                ->inlineLabel()
                ->schema([
                    TextInput::make('first_name')
                        ->label('Име')
                        ->readOnly(),
                    TextInput::make('last_name')
                        ->label('Презиме')
                        ->readOnly(),
                    TextInput::make('national_id')
                        ->label('ЈМБГ')
                        ->readOnly(),
                ]),
        ]);
    }
}
