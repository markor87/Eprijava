<?php

namespace App\Filament\Resources\VacancySources\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VacancySourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('internet_presentation')
                    ->label('Интернет')
                    ->formatStateUsing(fn($state) => is_array($state) && count($state) ? implode(', ', $state) : '—'),
                TextColumn::make('press')
                    ->label('Штампа')
                    ->formatStateUsing(fn($state) => is_array($state) && count($state) ? implode(', ', $state) : '—'),
                TextColumn::make('referral')
                    ->label('Пријатељи')
                    ->formatStateUsing(fn($state) => is_array($state) && count($state) ? implode(', ', $state) : '—'),
                TextColumn::make('nsz')
                    ->label('НСЗ')
                    ->formatStateUsing(fn($state) => is_array($state) && count($state) ? implode(', ', $state) : '—'),
                TextColumn::make('live')
                    ->label('Уживо')
                    ->formatStateUsing(fn($state) => is_array($state) && count($state) ? implode(', ', $state) : '—'),
                TextColumn::make('interested_in_other_jobs')
                    ->label('Заинтересован за друге послове')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
