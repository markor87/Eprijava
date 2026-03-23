<?php

namespace App\Filament\Resources\Declarations\Schemas;

use App\Models\NationalMinority;
use App\Models\RequiredProof;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Infolists\Components\TextEntry;
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
                    Radio::make('behavioral_competency_checked')
                        ->label('Да ли вам је у претходне две године на конкурсу за рад у државним органима вршена провера понашајних компетенција?')
                        ->options(['yes' => 'Да', 'no' => 'Не'])
                        ->required()
                        ->live()
                        ->columnSpanFull(),
                    TextInput::make('behavioral_competency_checked_body')
                        ->label('Наведите државни орган у ком сте конкурисали када су вам тестиране понашајне компетенције')
                        ->visible(fn($get) => $get('behavioral_competency_checked') === 'yes')
                        ->columnSpanFull(),
                    Radio::make('behavioral_competency_passed')
                        ->label('Ако је претходни одговор ДА, одговорите да ли сте тада успешно прошли проверу понашајних компетенција?')
                        ->options([
                            'yes'           => 'Да',
                            'no'            => 'Не',
                            'dont_remember' => 'Не сећам се',
                        ])
                        ->visible(fn($get) => $get('behavioral_competency_checked') === 'yes')
                        ->columnSpanFull(),
                ]),

            Section::make('Докази уз пријаву')
                ->schema([
                    Repeater::make('declarationProofs')
                        ->relationship('declarationProofs')
                        ->label('')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->default(fn() => RequiredProof::orderBy('sort_order')->get()->map(fn($proof) => [
                            'required_proof_id' => $proof->id,
                            'declaration_choice' => null,
                        ])->toArray())
                        ->schema([
                            Hidden::make('required_proof_id'),
                            TextEntry::make('proof_label')
                                ->label('Доказ')
                                ->state(fn($get) => RequiredProof::find($get('required_proof_id'))?->proof_description ?? '—'),
                            Select::make('declaration_choice')
                                ->label('Изјава кандидата')
                                ->options(fn($get) => match(RequiredProof::find($get('required_proof_id'))?->proof_type) {
                                    'official_records' => [
                                        'consent'             => 'Сагласан сам да орган прибави овај доказ из службених евиденција',
                                        'personally_obtained' => 'Лично сам прибавио доказ и достављам га уз ову пријаву',
                                    ],
                                    'personal' => [
                                        'yes' => 'Да',
                                        'no'  => 'Не',
                                    ],
                                    default => [],
                                })
                                ->required(),
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Изјава о потреби за посебним условима')
                ->schema([
                    Select::make('special_conditions_needed')
                        ->label('Да ли су вам потребни посебни услови за учешће у провери компетенција у оквиру селекције')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->live(),
                    TextInput::make('special_conditions_description')
                        ->label('Наведите које посебне услове захтевате')
                        ->visible(fn($get) => (int) $get('special_conditions_needed') === 1),
                ])
                ->columns(2),

            Section::make('Добровољна изјава о припадности националној мањини')
                ->schema([
                    Repeater::make('declarationMinorities')
                        ->relationship('declarationMinorities')
                        ->label('')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->default(fn() => NationalMinority::all()->map(fn($m) => [
                            'national_minority_id' => $m->id,
                            'choice'               => null,
                        ])->toArray())
                        ->schema([
                            Hidden::make('national_minority_id'),
                            TextEntry::make('minority_label')
                                ->label('Национална мањина')
                                ->state(fn($get) => NationalMinority::find($get('national_minority_id'))?->minority_name ?? '—'),
                            Select::make('choice')
                                ->label('Изјава кандидата')
                                ->options(['yes' => 'Да', 'no' => 'Не'])
                                ->required(),
                        ])
                        ->columns(2)
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
