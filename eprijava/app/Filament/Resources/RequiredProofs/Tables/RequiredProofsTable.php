<?php

namespace App\Filament\Resources\RequiredProofs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequiredProofsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Ред.')
                    ->sortable(),
                TextColumn::make('proof_description')
                    ->label('Опис доказа')
                    ->searchable(),
                TextColumn::make('proof_type')
                    ->label('Врста')
                    ->formatStateUsing(fn($state) => match($state) {
                        'official_records' => 'I (Орган)',
                        'personal'         => 'II (Кандидат)',
                        default            => $state,
                    }),
            ])
            ->defaultSort('sort_order')
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
