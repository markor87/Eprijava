<?php

namespace App\Filament\Resources\Competitions\Tables;

use App\Filament\Resources\JobPositions\JobPositionResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompetitionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('governmentBody.name')
                    ->label('Државни орган')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tip_konkursa')
                    ->label('Тип конкурса')
                    ->sortable(),
                TextColumn::make('datum_od')
                    ->label('Датум од')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('datum_do')
                    ->label('Датум до')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->state(fn ($record) => now()->between($record->datum_od->startOfDay(), $record->datum_do->endOfDay()) ? 'Активан' : 'Неактиван')
                    ->color(fn ($state) => $state === 'Активан' ? 'success' : 'danger'),
            ])
            ->filters([])
            ->recordActions([
                Action::make('job_positions')
                    ->label('Радна места')
                    ->url(fn($record) => JobPositionResource::getUrl('index', ['competition_id' => $record->id])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
