<?php

namespace App\Filament\Resources\JobPositions\Tables;

use App\Mail\ApplicationSubmitted;
use App\Models\Application;
use App\Models\ExamType;
use App\Models\ForeignLanguage;
use App\Models\GovernmentBody;
use App\Models\RequiredProof;
use App\Models\TrainingSet;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

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
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('employment_type')
                    ->label('Врста радног односа')
                    ->sortable(),
                TextColumn::make('workLocation.name')
                    ->label('Место рада')
                    ->sortable(),
                TextColumn::make('qualification_level')
                    ->label('Стручна спрема')
                    ->searchable()
                    ->sortable(),
            ])
            ->modifyQueryUsing(fn($query) => $query->with('competition'))
            ->filters([])
            ->recordActions([
                Action::make('apply')
                    ->label('Пријави се')
                    ->hidden(fn($record) => !$record->competition?->isActive())
                    ->requiresConfirmation()
                    ->modalHeading('Потврда пријаве')
                    ->modalDescription(fn($record) => 'Да ли желите да поднесете пријаву за радно место: ' . $record->position_name . '?')
                    ->modalSubmitActionLabel('Пријави се')
                    ->action(function ($record) {
                        $user = Auth::user();

                        if (!$record->competition?->isActive()) {
                            Notification::make()
                                ->title('Конкурс није активан')
                                ->body('Пријаве се могу поднети само током трајања конкурса.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $rateLimitKey = 'apply:' . $user->id;

                        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
                            $seconds = RateLimiter::availableIn($rateLimitKey);
                            $mod100  = $seconds % 100;
                            $mod10   = $seconds % 10;
                            $form    = ($mod100 >= 11 && $mod100 <= 19) ? 'секунди'
                                     : (($mod10 === 1) ? 'секунду'
                                     : (($mod10 >= 2 && $mod10 <= 4) ? 'секунде' : 'секунди'));
                            Notification::make()
                                ->title('Сачекајте тренутак')
                                ->body("Молимо вас сачекајте {$seconds} {$form} пре следеће пријаве.")
                                ->warning()
                                ->send();
                            return;
                        }

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

                        $record->loadMissing('rank', 'workLocation');
                        $candidate = $user->candidate;

                        $missing = [];

                        if (!$candidate?->first_name || !$candidate?->last_name || !$candidate?->national_id) {
                            $missing[] = 'лични подаци';
                        }
                        if (!$user->highSchoolEducations()->exists()) {
                            $missing[] = 'средња школа';
                        }
                        if (in_array($record->qualification_level, ['ВСС', 'ВШС']) && !$user->higherEducations()->exists()) {
                            $missing[] = 'виша/висока школа';
                        }
                        if (!$user->computerSkill()->exists()) {
                            $missing[] = 'рад на рачунару';
                        }
                        if (!$user->vacancySource()->exists()) {
                            $missing[] = 'сазнавање о конкурсу';
                        }
                        if (ExamType::exists() && !TrainingSet::where('user_id', $user->id)->whereHas('trainings')->exists()) {
                            $missing[] = 'стручни испити и други испити';
                        }
                        if (ForeignLanguage::exists() && !$user->foreignLanguageSkillSet()->exists()) {
                            $missing[] = 'страни језици';
                        }
                        if (RequiredProof::exists() && !$user->declaration()->exists()) {
                            $missing[] = 'изјава';
                        }

                        if (!empty($missing)) {
                            Notification::make()
                                ->title('Профил није попуњен')
                                ->body('Молимо вас да попуните следеће секције пре подношења пријаве: ' . implode(', ', $missing) . '.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $competition    = $record->competition;
                        $governmentBody = GovernmentBody::find($record->government_body_id);

                        RateLimiter::hit($rateLimitKey, 30);

                        try {
                            DB::transaction(function () use ($record, $user, $candidate, $competition, $governmentBody) {
                                $appCount = Application::where('job_position_id', $record->id)
                                    ->lockForUpdate()
                                    ->count() + 1;

                                $candidateCode =
                                    ($governmentBody?->government_body_code ?? '') .
                                    mb_substr($competition?->tip_konkursa ?? '', 0, 1) .
                                    ($competition?->datum_od?->format('dmy') ?? '') .
                                    ($record->sequence_number ?? '') .
                                    'И' .
                                    mb_substr($record->employment_type ?? '', 0, 1) .
                                    'Е' .
                                    $appCount;

                                Application::create([
                                    'user_id'            => $user->id,
                                    'competition_id'     => $record->competition_id,
                                    'government_body_id' => $record->government_body_id,
                                    'job_position_id'    => $record->id,
                                    'first_name'         => $candidate?->first_name,
                                    'last_name'          => $candidate?->last_name,
                                    'national_id'        => $candidate?->national_id,
                                    'candidate_code'     => $candidateCode,
                                    'org_unit_path'      => $record->org_unit_path,
                                    'rank_name'          => $record->rank?->name,
                                    'profile_snapshot'   => Application::buildProfileSnapshot($user),
                                ]);
                            });
                        } catch (QueryException) {
                            Notification::make()
                                ->title('Већ сте пријављени')
                                ->body('Пријава за ово радно место је већ поднета.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $application = Application::where('user_id', $user->id)
                            ->where('job_position_id', $record->id)
                            ->first();

                        $record->setRelation('competition', $competition);
                        $record->setRelation('governmentBody', $governmentBody);

                        Mail::to($candidate?->email ?? $user->email)->send(new ApplicationSubmitted($user, $record, $application));

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
