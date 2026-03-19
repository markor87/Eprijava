<?php

namespace App\Filament\Resources\Trainings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exam_type')
                    ->label('Врста испита')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('issuing_authority')
                    ->label('Орган / правно лице')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('exam_date')
                    ->label('Датум похађања')
                    ->date('d.m.Y.')
                    ->placeholder('—'),
                TextColumn::make('has_certificate')
                    ->label('Сертификат')
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
