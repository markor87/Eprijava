<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('governmentBody.name')
                    ->label('Орган')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jobPosition.position_name')
                    ->label('Радно место')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->label('Ime')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Prezime')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label('ЈМБГ')
                    ->searchable(),
                TextColumn::make('candidate_code')
                    ->label('Шифра кандидата')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('rank_name')
                    ->label('Звање')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Датум пријаве')
                    ->date('d.m.Y')
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
