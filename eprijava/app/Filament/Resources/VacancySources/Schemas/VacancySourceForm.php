<?php

namespace App\Filament\Resources\VacancySources\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VacancySourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Интернет презентација')
                ->schema([
                    CheckboxList::make('internet_presentation')
                        ->label('')
                        ->options([
                            'hr_services' => 'Службе за управљање кадровима',
                            'organ'       => 'Органа',
                            'other'       => 'друго',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Штампа')
                ->schema([
                    CheckboxList::make('press')
                        ->label('')
                        ->options([
                            'daily_newspapers' => 'Дневне новине',
                            'other'            => 'друго',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Преко пријатеља и познаника')
                ->schema([
                    CheckboxList::make('referral')
                        ->label('')
                        ->options([
                            'employee' => 'Запослени у органу',
                            'manager'  => 'Руководилац у органу',
                            'other'    => 'друго',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Национална служба за запошљавање')
                ->schema([
                    CheckboxList::make('nsz')
                        ->label('')
                        ->options([
                            'internet'           => 'Интернет презентација',
                            'jobs_list'          => 'Лист Послови',
                            'advisor_invitation' => 'Позив саветника из НСЗ',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Уживо')
                ->schema([
                    CheckboxList::make('live')
                        ->label('')
                        ->options([
                            'job_fair'                => 'Сајам запошљавања',
                            'hr_unit'                 => 'Кадровска јединица органа — претходни конкурс',
                            'university_presentation' => 'Презентација на факултету',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Заинтересованост за друге послове')
                ->schema([
                    Select::make('interested_in_other_jobs')
                        ->label('Заинтересован сам и за друге послове у државној управи и можете ме позвати на неки други одговарајући конкурс, уколико ми на овом конкурсу не буде понуђен посао')
                        ->options([1 => 'Да', 0 => 'Не'])
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
