<?php

namespace App\Filament\Resources\AcademicTitles\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicTitlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('educational_scientific_field')
                    ->label('Образовно-научно поље')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scientific_professional_area')
                    ->label('Научно-стручна област')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Звање')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
