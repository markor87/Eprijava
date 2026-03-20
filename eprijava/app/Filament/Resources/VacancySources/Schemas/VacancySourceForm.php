<?php

namespace App\Filament\Resources\VacancySources\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VacancySourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Како сте сазнали за овај конкурс?')
                ->schema([
                    Radio::make('source')
                        ->label('')
                        ->options([
                            'hr_services'             => 'Интернет презентација — Службе за управљање кадровима',
                            'organ'                   => 'Интернет презентација — Органа',
                            'internet_other'          => 'Интернет презентација — друго',
                            'daily_newspapers'        => 'Штампа — Дневне новине',
                            'press_other'             => 'Штампа — друго',
                            'employee'                => 'Преко пријатеља и познаника — Запослени у органу',
                            'manager'                 => 'Преко пријатеља и познаника — Руководилац у органу',
                            'referral_other'          => 'Преко пријатеља и познаника — друго',
                            'internet'                => 'Национална служба за запошљавање — Интернет презентација',
                            'jobs_list'               => 'Национална служба за запошљавање — Лист Послови',
                            'advisor_invitation'      => 'Национална служба за запошљавање — Позив саветника из НСЗ',
                            'job_fair'                => 'Уживо — Сајам запошљавања',
                            'hr_unit'                 => 'Уживо — Кадровска јединица органа (претходни конкурс)',
                            'university_presentation' => 'Уживо — Презентација на факултету',
                        ])
                        ->required()
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
