<?php

namespace App\Filament\Resources\JobPositions\Schemas;

use App\Models\AcademicTitle;
use App\Models\Place;
use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Радно место')
                ->inlineLabel()
                ->schema([
                    TextInput::make('position_name')
                        ->label('Назив радног места')
                        ->rule(new SerbianCyrillic())
                        ->required(),
                    TextInput::make('sequence_number')
                        ->label('Редни број')
                        ->numeric(),
                    TextInput::make('organizational_unit')
                        ->label('Организациона јединица')
                        ->rule(new SerbianCyrillic()),
                    TextInput::make('org_unit_path')
                        ->label('Путања орг. јединице'),
                    TextInput::make('sector')
                        ->label('Сектор')
                        ->rule(new SerbianCyrillic()),
                    Select::make('employment_type')
                        ->label('Врста радног односа')
                        ->options([
                            'Неодређено' => 'Неодређено',
                            'Одређено'   => 'Одређено',
                        ]),
                    Select::make('work_location_id')
                        ->label('Место рада')
                        ->options(Place::query()->orderBy('name')->pluck('name', 'id'))
                        ->searchable(),
                    Select::make('educational_scientific_field_id')
                        ->label('Образовно-научна област')
                        ->options(
                            AcademicTitle::query()
                                ->distinct()
                                ->orderBy('educational_scientific_field')
                                ->pluck('educational_scientific_field', 'educational_scientific_field')
                        )
                        ->searchable()
                        ->live(),
                    Select::make('scientific_professional_field_id')
                        ->label('Научно-стручна област')
                        ->options(fn($get) => AcademicTitle::query()
                            ->when(
                                $get('educational_scientific_field_id'),
                                fn($q, $field) => $q->where('educational_scientific_field', $field)
                            )
                            ->distinct()
                            ->orderBy('scientific_professional_area')
                            ->pluck('scientific_professional_area', 'scientific_professional_area')
                        )
                        ->searchable(),
                    TextInput::make('title_id')
                        ->label('Звање')
                        ->numeric(),
                    TextInput::make('qualification_level')
                        ->label('Стручна спрема')
                        ->rule(new SerbianCyrillic()),
                    TextInput::make('executor_count')
                        ->label('Број извршилаца')
                        ->numeric(),
                ]),
        ]);
    }
}
