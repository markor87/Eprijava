<?php

namespace App\Filament\Resources\Konkursi\Schemas;

use App\Models\GovernmentBody;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KonkursForm
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
                        ->searchable()
                        ->required(),
                    Select::make('tip_konkursa')
                        ->label('Тип конкурса')
                        ->options(['Јавни' => 'Јавни', 'Интерни' => 'Интерни'])
                        ->required(),
                    DatePicker::make('datum_od')
                        ->label('Датум од')
                        ->native(false)
                        ->required(),
                    DatePicker::make('datum_do')
                        ->label('Датум до')
                        ->native(false)
                        ->required(),
                ]),
        ]);
    }
}
