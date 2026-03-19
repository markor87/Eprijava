<?php

namespace App\Filament\Resources\ComputerSkills\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComputerSkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('word_has_certificate')
                    ->label('Word')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('excel_has_certificate')
                    ->label('Excel')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('internet_has_certificate')
                    ->label('Internet')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('word_exemption_requested')
                    ->label('Word – ослобађање')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('excel_exemption_requested')
                    ->label('Excel – ослобађање')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('internet_exemption_requested')
                    ->label('Internet – ослобађање')
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
