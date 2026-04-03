<?php

namespace App\Filament\Resources\Trainings\Pages;

use App\Filament\Resources\Trainings\TrainingResource;
use App\Models\TrainingSet;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTrainings extends ListRecords
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if (!$user?->hasRole('super_admin') && !$user?->can('Create:TrainingSet')) {
            return [];
        }

        $set = TrainingSet::where('user_id', Auth::id())->first();

        if ($set) {
            return [
                Action::make('edit_my_trainings')
                    ->label('Стручни и други испити')
                    ->url(TrainingResource::getUrl('edit', ['record' => $set->id])),
            ];
        }

        return [
            Action::make('edit_my_trainings')
                ->label('Стручни и други испити')
                ->action(function () {
                    $set = TrainingSet::create(['user_id' => Auth::id()]);
                    $this->redirect(TrainingResource::getUrl('edit', ['record' => $set->id]));
                }),
        ];
    }
}
