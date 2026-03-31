<?php

namespace App\Filament\Resources\Declarations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeclarationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wants_functional_competency_exemption')
                    ->label('Ослобађање тестирања')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('behavioral_competency_checked')
                    ->label('Понашајне компетенције')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('special_conditions_needed')
                    ->label('Посебни услови')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('employment_terminated_for_breach')
                    ->label('Отпуштен због повреде')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('official_data_collection')
                    ->label('Прибављање података')
                    ->formatStateUsing(fn($state) => match($state) {
                        'personally' => 'Лично',
                        'by_body'    => 'Орган',
                        default      => '—',
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
