<?php

namespace App\Filament\Resources\VacancySources\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VacancySourcesTable
{
    private static array $sourceLabels = [
        'hr_services'             => 'Интернет — Службе за управљање кадровима',
        'organ'                   => 'Интернет — Органа',
        'internet_other'          => 'Интернет — друго',
        'daily_newspapers'        => 'Штампа — Дневне новине',
        'press_other'             => 'Штампа — друго',
        'employee'                => 'Пријатељи — Запослени у органу',
        'manager'                 => 'Пријатељи — Руководилац у органу',
        'referral_other'          => 'Пријатељи — друго',
        'internet'                => 'НСЗ — Интернет презентација',
        'jobs_list'               => 'НСЗ — Лист Послови',
        'advisor_invitation'      => 'НСЗ — Позив саветника',
        'job_fair'                => 'Уживо — Сајам запошљавања',
        'hr_unit'                 => 'Уживо — Кадровска јединица органа',
        'university_presentation' => 'Уживо — Презентација на факултету',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('source')
                    ->label('Извор')
                    ->formatStateUsing(fn($state) => self::$sourceLabels[$state] ?? '—')
                    ->wrap(),
                TextColumn::make('interested_in_other_jobs')
                    ->label('Заинтересован за друге послове')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
