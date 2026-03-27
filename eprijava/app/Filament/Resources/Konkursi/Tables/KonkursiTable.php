<?php

namespace App\Filament\Resources\Konkursi\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KonkursiTable
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
                    ->date()
                    ->sortable(),
                TextColumn::make('datum_do')
                    ->label('Датум до')
                    ->date()
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
