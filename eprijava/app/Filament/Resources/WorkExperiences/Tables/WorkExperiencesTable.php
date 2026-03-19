<?php

namespace App\Filament\Resources\WorkExperiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employer_name')
                    ->label('Послодавац')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->label('Радно место')
                    ->searchable(),
                TextColumn::make('period_from')
                    ->label('Од')
                    ->date('d.m.Y.')
                    ->sortable(),
                TextColumn::make('period_to')
                    ->label('До')
                    ->date('d.m.Y.')
                    ->placeholder('тренутно'),
                TextColumn::make('employment_basis')
                    ->label('Основ ангажовања')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'fixed_term' => 'одређено време',
                        'permanent'  => 'неодређено време',
                        'other'      => 'други уговор',
                        default      => $state ?? '—',
                    })
                    ->placeholder('—'),
            ])
            ->defaultSort('period_from', 'desc')
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
