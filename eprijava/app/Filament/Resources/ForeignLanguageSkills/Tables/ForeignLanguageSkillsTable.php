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
                TextColumn::make('languages_entered')
                    ->label('Унети језици')
                    ->getStateUsing(fn($record) => $record->foreignLanguageSkills
                        ->filter(fn($s) => $s->level !== null)
                        ->map(fn($s) => $s->foreignLanguage?->language_name)
                        ->filter()
                        ->join(', ') ?: '—'
                    ),
                TextColumn::make('certificate_attachment')
                    ->label('Сертификат приложен')
                    ->getStateUsing(fn($record) => !empty($record->certificate_attachment) ? 'Да' : 'Не'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
