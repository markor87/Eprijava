<?php

namespace App\Filament\Resources\WorkExperiences\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Радно искуство')
                ->schema([
                    DatePicker::make('period_from')
                        ->label('Период од')
                        ->required()
                        ->native(false),
                    DatePicker::make('period_to')
                        ->label('Период до')
                        ->helperText('Оставите празно ако је тренутно радно место')
                        ->native(false),
                    TextInput::make('employer_name')
                        ->label('Назив послодавца')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('job_title')
                        ->label('Назив радног места')
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('job_description')
                        ->label('Опис посла')
                        ->rows(3)
                        ->columnSpanFull(),
                    Select::make('employment_basis')
                        ->label('Основ ангажовања')
                        ->options([
                            'fixed_term' => 'уговор о раду / решење о пријему у радни однос на одређено време',
                            'permanent'  => 'уговор о раду / решење о пријему у радни однос на неодређено време',
                            'other'      => 'други уговор',
                        ])
                        ->columnSpanFull(),
                    CheckboxList::make('required_education')
                        ->label('Захтевано образовање')
                        ->helperText('Можете обележити више одговора ако су такви захтеви били одређени уговором о радном ангажовању')
                        ->options([
                            'high_school'  => 'средња школа/гимназија',
                            '3yr_180espb'  => 'студије у трајању до 3 године (по прописима до 10. септембра 2005. године) / студије у обиму од 180 ЕСПБ',
                            '4yr_240espb'  => 'основне студије у трајању од најмање 4 године (по прописима до 10.9.2005. године) / академске студије у обиму од најмање 240 бодова / најмање специјалистичке струковне студије',
                        ])
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
