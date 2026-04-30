<?php

namespace App\Filament\Resources\ComputerSkills\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComputerSkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('computer_skills_summary')
                    ->label('Сертификат')
                    ->getStateUsing(fn($record) => collect([
                        'Word'     => $record->word_has_certificate,
                        'Excel'    => $record->excel_has_certificate,
                        'Internet' => $record->internet_has_certificate,
                    ])->map(fn($val, $name) => $name . ': ' . ($val ? 'Да' : 'Не'))->join(', ')),
                TextColumn::make('exemptions_summary')
                    ->label('Ослобађање')
                    ->getStateUsing(fn($record) => collect([
                        'Word'     => $record->word_exemption_requested,
                        'Excel'    => $record->excel_exemption_requested,
                        'Internet' => $record->internet_exemption_requested,
                    ])->map(fn($val, $name) => $name . ': ' . ($val ? 'Да' : 'Не'))->join(', ')),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
