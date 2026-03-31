<?php

namespace App\Filament\Resources\RequiredProofs\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequiredProofsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('proof_description')
                    ->label('Опис доказа')
                    ->searchable(),
                TextColumn::make('proof_type')
                    ->label('Врста')
                    ->formatStateUsing(fn($state) => match($state) {
                        'official_records' => 'Орган прибавља из службених евиденција',
                        'personal'         => 'Кандидат лично доставља',
                        default            => $state,
                    }),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
