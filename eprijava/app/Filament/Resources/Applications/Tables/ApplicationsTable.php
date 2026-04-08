<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\Application;
use App\Models\ForeignLanguageSkillSet;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('governmentBody.name')
                    ->label('Орган')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jobPosition.position_name')
                    ->label('Радно место')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->label('Ime')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Prezime')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label('ЈМБГ')
                    ->searchable(),
                TextColumn::make('candidate_code')
                    ->label('Шифра кандидата')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('rank_name')
                    ->label('Звање')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Датум пријаве')
                    ->date('d.m.Y')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                Action::make('download_pdf')
                    ->label('Преузми PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(function (Application $record) {
                        $user = $record->user;

                        if ($record->profile_snapshot !== null) {
                            $profileData = $record->hydrateSnapshotForPdf();
                        } else {
                            // Legacy fallback for applications submitted before snapshot was introduced
                            $profileData = [
                                'candidate'           => $user->candidate?->load(['placeOfBirth', 'addressCity', 'deliveryCity']),
                                'highSchoolEducation' => $user->highSchoolEducations()->first(),
                                'higherEducations'    => $user->higherEducations()->with(['academicTitle', 'institutionLocation'])->get(),
                                'workExperiences'     => $user->workExperiences()->orderByDesc('period_from')->get(),
                                'trainings'           => $user->trainingSet?->trainings()->with('examType')->orderBy('exam_date')->get() ?? collect(),
                                'foreignSkillSet'     => ForeignLanguageSkillSet::where('user_id', $user->id)
                                                            ->with('foreignLanguageSkills.foreignLanguage')
                                                            ->first(),
                                'computerSkill'       => $user->computerSkill,
                                'additionalTrainings' => $user->additionalTrainings()->orderBy('year')->get(),
                                'declaration'         => $user->declaration?->load([
                                                            'declarationProofs.requiredProof',
                                                            'declarationMinorities.nationalMinority',
                                                        ]),
                                'vacancySource'       => $user->vacancySource,
                            ];
                        }

                        $pdf = Pdf::loadView('pdf.application', array_merge(
                            ['record' => $record->load(['jobPosition', 'competition', 'governmentBody'])],
                            $profileData
                        ))->setPaper('a4', 'portrait');

                        $filename = implode('_', array_filter([
                            $record->first_name,
                            $record->last_name,
                            $record->national_id,
                            $record->candidate_code,
                        ])) . '.pdf';

                        return response()->streamDownload(fn() => print($pdf->output()), $filename);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
