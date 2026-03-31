<?php

namespace App\Filament\Resources\HighSchoolEducations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HighSchoolEducationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('institution_name')
                    ->label('Назив школе')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('institution_location')
                    ->label('Седиште')
                    ->searchable(),
                TextColumn::make('direction')
                    ->label('Смер')
                    ->placeholder('—'),
                TextColumn::make('graduation_year')
                    ->label('Год. завршетка')
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
