<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Стручни и други испити')
                ->inlineLabel()
                ->schema([
                    Select::make('has_certificate')
                        ->label('Да ли поседујете сертификат')
                        ->options([
                            1 => 'Да',
                            0 => 'Не',
                        ])
                        ->required(),
                    DatePicker::make('exam_date')
                        ->label('Датум похађања')
                        ->required()
                        ->native(false)
                        ->displayFormat('d.m.Y'),
                    Select::make('exam_type')
                        ->label('Врста испита')
                        ->options([
                            'Државни стручни испит' => 'Државни стручни испит',
                            'Испит за инспектора'   => 'Испит за инспектора',
                            'Правосудни испит'      => 'Правосудни испит',
                        ])
                        ->required(),
                    TextInput::make('issuing_authority')
                        ->label('Назив органа / правног лица које је издало доказ')
                        ->rule(new SerbianCyrillic())
                        ->required(),
                ]),
        ]);
    }
}
