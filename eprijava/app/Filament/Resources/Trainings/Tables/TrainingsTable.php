<?php

namespace App\Filament\Resources\Trainings\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exams_entered')
                    ->label('Унети испити')
                    ->getStateUsing(fn($record) => $record->trainings
                        ->filter(fn($t) => $t->has_certificate !== null)
                        ->map(fn($t) => ($t->examType?->name ?? '—') . ': ' . ($t->has_certificate ? 'Да' : 'Не'))
                        ->join(', ') ?: '—'
                    ),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
