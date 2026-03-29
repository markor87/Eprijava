<?php

namespace App\Filament\Resources\JobPositions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobPositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sequence_number')
                    ->label('Рб.')
                    ->sortable(),
                TextColumn::make('position_name')
                    ->label('Назив радног места')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label('Врста радног односа')
                    ->sortable(),
                TextColumn::make('workLocation.name')
                    ->label('Место рада')
                    ->sortable(),
                TextColumn::make('executor_count')
                    ->label('Број извршилаца')
                    ->sortable(),
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
