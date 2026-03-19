<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ForeignLanguageSkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('language')
                    ->label('Страни језик')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->label('Ниво')
                    ->sortable(),
                TextColumn::make('has_certificate')
                    ->label('Сертификат')
                    ->formatStateUsing(fn($state) => $state ? 'Да' : 'Не'),
                TextColumn::make('year_of_examination')
                    ->label('Година полагања')
                    ->placeholder('—'),
                TextColumn::make('exemption_requested')
                    ->label('Ослобађање тестирања')
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
