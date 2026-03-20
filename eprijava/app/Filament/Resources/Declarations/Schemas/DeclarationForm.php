<?php

namespace App\Filament\Resources\Declarations\Schemas;

use App\Models\RequiredProof;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeclarationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Ослобађање тестирања општих функционалних компетенција')
                ->schema([
                    Select::make('wants_functional_competency_exemption')
                        ->label('Да ли желите да будете ослобођени тестирања општих функционалних компетенција, ако испуњавате услове за ослобађање од тестирања')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Провера понашајних компетенција')
                ->schema([
                    Select::make('behavioral_competency_checked')
                        ->label('Да ли вам је у претходне две године на конкурсу за рад у државним органима вршена провера понашајних компетенција')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    TextInput::make('behavioral_competency_checked_body')
                        ->label('Државни орган у ком сте конкурисали')
                        ->visible(fn($get) => $get('behavioral_competency_checked')),
                    Select::make('behavioral_competency_passed')
                        ->label('Да ли сте тада успешно прошли проверу понашајних компетенција')
                        ->options([
                            'yes'           => 'Да',
                            'no'            => 'Не',
                            'dont_remember' => 'Не сећам се',
                        ])
                        ->visible(fn($get) => $get('behavioral_competency_checked'))
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Докази уз пријаву')
                ->schema([
                    Repeater::make('declarationProofs')
                        ->relationship('declarationProofs')
                        ->label('Докази')
                        ->addActionLabel('Додај доказ')
                        ->schema([
                            Select::make('required_proof_id')
                                ->label('Доказ')
                                ->options(fn() => RequiredProof::orderBy('sort_order')->pluck('proof_description', 'id'))
                                ->required()
                                ->columnSpanFull(),
                            Select::make('declaration_choice')
                                ->label('Изјава кандидата')
                                ->options([
                                    'consent'             => 'Сагласан сам да орган прибави из службених евиденција',
                                    'personally_obtained' => 'Лично сам прибавио доказ и достављам га уз пријаву',
                                    'yes'                 => 'Да (достављам)',
                                    'no'                  => 'Не (не достављам)',
                                ])
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Изјава о потреби за посебним условима')
                ->schema([
                    Select::make('special_conditions_needed')
                        ->label('Да ли су вам потребни посебни услови за учешће у провери компетенција у оквиру селекције')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required(),
                    TextInput::make('special_conditions_description')
                        ->label('Наведите које посебне услове захтевате')
                        ->visible(fn($get) => $get('special_conditions_needed')),
                ])
                ->columns(2),

            Section::make('Добровољна изјава о припадности националној мањини')
                ->schema([
                    Select::make('national_minority_member')
                        ->label('Да ли припадате националној мањини')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Додатне изјаве')
                ->schema([
                    Select::make('employment_terminated_for_breach')
                        ->label('Да ли вам је у прошлости престајао радни однос у државном органу због теже повреде дужности из радног односа')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->columnSpanFull(),
                    Select::make('official_data_collection')
                        ->label('Начин прибављања података из других службених евиденција')
                        ->options([
                            'personally' => 'Лично ћу прибавити и доставити доказе',
                            'by_body'    => 'Желим да орган прибави доказе из службених евиденција',
                        ])
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
