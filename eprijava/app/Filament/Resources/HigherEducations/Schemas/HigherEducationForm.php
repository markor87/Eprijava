<?php

namespace App\Filament\Resources\HigherEducations\Schemas;

use App\Filament\Resources\AcademicTitles\Tables\AcademicTitleSelectTable;
use App\Models\Place;
use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ModalTableSelect;
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
                ->inlineLabel()
                ->schema([
                    Select::make('study_type')
                        ->label('Врста студија')
                        ->options([
                            'basic_4yr'           => 'Основне студије у трајању од најмање 4 године (до 10.9.2005.)',
                            '3yr'                 => 'Студије у трајању до 3 године (до 10.9.2005.) / 180 ЕСПБ',
                            'academic'            => 'Академске студије',
                            'vocational'          => 'Струковне студије',
                            'vocational_academic' => 'Струковне и академске студије',
                        ])
                        ->live(),
                    Select::make('volume_espb')
                        ->label('Обим студија (ЕСПБ)')
                        ->options(fn($get) => match($get('study_type')) {
                            'basic_4yr'           => [240 => '240'],
                            '3yr'                 => [180 => '180'],
                            'academic'            => [60 => '60', 120 => '120', 240 => '240'],
                            'vocational'          => [60 => '60', 120 => '120', 180 => '180', 240 => '240', 300 => '300', 420 => '420'],
                            'vocational_academic' => [60 => '60', 120 => '120', 180 => '180', 240 => '240', 300 => '300', 420 => '420'],
                            default               => [],
                        }),
                    TextInput::make('institution_name')
                        ->label('Назив факултета / установе')
                        ->rule(new SerbianCyrillic()),
                    Select::make('institution_location_id')
                        ->label('Место')
                        ->options(Place::query()->orderBy('name')->pluck('name', 'id'))
                        ->searchable(),
                    TextInput::make('program_name')
                        ->label('Назив акредитованог студијског програма, смер/модул')
                        ->rule(new SerbianCyrillic()),
                    ModalTableSelect::make('title_id')
                        ->label('Стечено звање')
                        ->tableConfiguration(AcademicTitleSelectTable::class)
                        ->relationship('academicTitle', 'title')
                        ->getOptionLabelFromRecordUsing(fn($record) => "{$record->educational_scientific_field} — {$record->scientific_professional_area} — {$record->title}"),
                    DatePicker::make('graduation_date')
                        ->label('Датум завршетка')
                        ->native(false),
                ]),
        ]);
    }
}
