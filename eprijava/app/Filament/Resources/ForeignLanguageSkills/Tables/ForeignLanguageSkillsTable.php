<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ForeignLanguageSkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('languages_summary')
                    ->label('Унети језици')
                    ->getStateUsing(fn($record) => $record->foreignLanguageSkills
                        ->filter(fn($s) => $s->has_certificate !== null)
                        ->map(fn($s) => ($s->foreignLanguage?->language_name ?? '—') . ': ' . ($s->has_certificate ? 'Да' : 'Не'))
                        ->join(', ') ?: '—'
                    ),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
