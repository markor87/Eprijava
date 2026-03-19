<?php

namespace App\Filament\Resources\HigherEducations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HigherEducationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('institution_name')
                    ->label('Назив факултета / установе')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('institution_location')
                    ->label('Место')
                    ->searchable(),
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
                TextColumn::make('graduation_date')
                    ->label('Датум завршетка')
                    ->placeholder('—'),
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
