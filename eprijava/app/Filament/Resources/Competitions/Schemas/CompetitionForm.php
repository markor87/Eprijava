<?php

namespace App\Filament\Resources\Competitions\Schemas;

use App\Models\GovernmentBody;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompetitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Конкурс')
                ->inlineLabel()
                ->schema([
                    Select::make('government_body_id')
                        ->label('Државни орган')
                        ->options(GovernmentBody::query()->pluck('name', 'id'))
                        ->default(fn() => auth()->user()?->government_body_id)
                        ->disabled()
                        ->dehydrated(false),
                    Select::make('tip_konkursa')
                        ->label('Тип конкурса')
                        ->options(['Јавни' => 'Јавни', 'Интерни' => 'Интерни'])
                        ->required(),
                    DatePicker::make('datum_od')
                        ->label('Датум од')
                        ->native(false)
                        ->displayFormat('d.m.Y')
                        ->required(),
                    DatePicker::make('datum_do')
                        ->label('Датум до')
                        ->native(false)
                        ->displayFormat('d.m.Y')
                        ->required(),
                ]),
        ]);
    }
}
