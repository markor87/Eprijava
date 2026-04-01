<?php

namespace App\Filament\Resources\JobPositions\Tables;

use App\Mail\ApplicationSubmitted;
use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobPositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sequence_number')
                    ->label('Рб.')
                    ->sortable(),
                TextColumn::make('position_name')
                    ->label('Назив радног места')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label('Врста радног односа')
                    ->sortable(),
                TextColumn::make('workLocation.name')
                    ->label('Место рада')
                    ->sortable(),
                TextColumn::make('executor_count')
                    ->label('Број извршилаца')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                Action::make('apply')
                    ->label('Пријави се')
                    ->requiresConfirmation()
                    ->modalHeading('Потврда пријаве')
                    ->modalDescription(fn($record) => 'Да ли желите да поднесете пријаву за радно место: ' . $record->position_name . '?')
                    ->modalSubmitActionLabel('Пријави се')
                    ->action(function ($record) {
                        $user = Auth::user();

                        $alreadyApplied = Application::where('user_id', $user->id)
                            ->where('job_position_id', $record->id)
                            ->exists();

                        if ($alreadyApplied) {
                            Notification::make()
                                ->title('Већ сте пријављени')
                                ->body('Пријава за ово радно место је већ поднета.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $record->loadMissing('rank');
                        $candidate = $user->candidate;

                        Application::create([
                            'user_id'            => $user->id,
                            'competition_id'     => $record->competition_id,
                            'government_body_id' => $record->government_body_id,
                            'job_position_id'    => $record->id,
                            'first_name'         => $candidate?->first_name,
                            'last_name'          => $candidate?->last_name,
                            'national_id'        => $candidate?->national_id,
                            'org_unit_path'      => $record->org_unit_path,
                            'rank_name'          => $record->rank?->name,
                        ]);

                        Mail::to($user->email)->send(new ApplicationSubmitted($user, $record));

                        Notification::make()
                            ->title('Пријава је успешно поднета')
                            ->body('Потврда је послата на вашу е-пошту адресу.')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make()
                    ->before(function ($record, $action) {
                        if (Application::where('job_position_id', $record->id)->exists()) {
                            Notification::make()
                                ->title('Брисање није могуће')
                                ->body('Радно место има поднете пријаве и не може бити обрисано.')
                                ->danger()
                                ->send();
                            $action->halt();
                        }
                    }),
            ])
            ->toolbarActions([]);
    }
}
