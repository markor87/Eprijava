<?php

namespace App\Filament\Resources\HigherEducations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HigherEducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Високо образовање')
                ->schema([
                    Select::make('study_type')
                        ->label('Врста студија')
                        ->options([
                            'basic_4yr'           => 'Основне студије у трајању од најмање 4 године (до 10.9.2005.)',
                            '3yr'                 => 'Студије у трајању до 3 године (до 10.9.2005.) / 180 ЕСПБ',
                            'academic'            => 'Академске студије (240+ ЕСПБ)',
                            'vocational'          => 'Струковне студије',
                            'vocational_academic' => 'Струковне и академске студије',
                        ])
                        ->columnSpanFull(),
                    TextInput::make('institution_name')
                        ->label('Назив факултета / установе')
                        ->columnSpanFull(),
                    TextInput::make('institution_location')
                        ->label('Место'),
                    TextInput::make('volume_espb_or_years')
                        ->label('Обим студија (ЕСПБ или године)')
                        ->placeholder('нпр. 240 ЕСПБ или 4 године'),
                    TextInput::make('program_name')
                        ->label('Назив акредитованог студијског програма, смер/модул')
                        ->columnSpanFull(),
                    TextInput::make('title_obtained')
                        ->label('Стечено звање'),
                    TextInput::make('graduation_date')
                        ->label('Датум завршетка (дан/месец/година)')
                        ->placeholder('нпр. 15.06.2020.'),
                ])
                ->columns(2),
        ]);
    }
}
