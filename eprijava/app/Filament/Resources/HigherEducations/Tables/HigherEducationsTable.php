<?php

namespace App\Filament\Resources\HigherEducations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HigherEducationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->description('Наведите од најнижег до највишег звања које сте стекли (студије првог степена, студије другог степена, студије трећег степена / докторске академске студије)')
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('institution_name')
                    ->label('Назив факултета / установе')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('institutionLocation.name')
                    ->label('Место')
                    ->sortable(),
                TextColumn::make('study_type')
                    ->label('Врста студија')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'basic_4yr'           => 'Основне 4 год.',
                        '3yr'                 => '3 год. / 180 ЕСПБ',
                        'academic'            => 'Академске',
                        'vocational'          => 'Струковне',
                        'vocational_academic' => 'Струковне и академске',
                        default               => $state ?? '—',
                    })
                    ->placeholder('—'),
                TextColumn::make('volume_espb')
                    ->label('Обим студија (ЕСПБ)')
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
