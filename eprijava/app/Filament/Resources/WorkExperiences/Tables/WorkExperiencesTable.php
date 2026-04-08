<?php

namespace App\Filament\Resources\WorkExperiences\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->description('Напомена: За учествовање у овом конкурсу морате имати најмање онај број година радног искуства у струци/државним органима које је тражено у огласу као услов за рад на овом радном месту. Молимо да још једном пажљиво погледате тражено радно искуство које је наведено у огласу за овај конкурс и након тога попуните овај део обрасца. Ако из података које наведете у овој пријави произилази да немате потребно радно искуство, ваша пријава ће бити одбачена.')
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employer_name')
                    ->label('Послодавац')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->label('Радно место')
                    ->searchable(),
                TextColumn::make('period_from')
                    ->label('Од')
                    ->date('d.m.Y.')
                    ->sortable(),
                TextColumn::make('period_to')
                    ->label('До')
                    ->date('d.m.Y.')
                    ->placeholder('тренутно'),
            ])
            ->defaultSort('period_from', 'desc')
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
