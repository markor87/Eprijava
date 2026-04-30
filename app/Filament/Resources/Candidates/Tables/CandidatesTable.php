<?php

namespace App\Filament\Resources\Candidates\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Презиме')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->label('Име')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label('ЈМБГ')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Е-пошта')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Телефон'),
                TextColumn::make('addressCity.name')
                    ->label('Место')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Креиран')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
