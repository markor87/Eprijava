<?php

namespace App\Filament\Resources\AdditionalTrainings\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdditionalTrainingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('training_name')
                    ->label('Обука / страни језик')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('institution_name')
                    ->label('Назив институције')
                    ->limit(40)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('location_or_level')
                    ->label('Место / ниво знања'),
                TextColumn::make('year')
                    ->label('Година')
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
