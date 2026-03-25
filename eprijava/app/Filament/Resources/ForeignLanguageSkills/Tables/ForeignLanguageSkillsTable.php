<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Tables;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguageSkill;
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
                TextColumn::make('foreignLanguage.language_name')
                    ->label('Страни језик')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->label('Ниво')
                    ->placeholder('—'),
                TextColumn::make('has_certificate')
                    ->label('Сертификат')
                    ->formatStateUsing(fn($state) => $state === null ? '—' : ($state ? 'Да' : 'Не')),
                TextColumn::make('year_of_examination')
                    ->label('Година полагања')
                    ->placeholder('—'),
                TextColumn::make('exemption_requested')
                    ->label('Ослобађање тестирања')
                    ->formatStateUsing(fn($state) => $state === null ? '—' : ($state ? 'Да' : 'Не')),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->url(fn(ForeignLanguageSkill $record) => ForeignLanguageSkillResource::getUrl('edit', [
                        'record' => $record->foreign_language_skill_set_id,
                    ])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
