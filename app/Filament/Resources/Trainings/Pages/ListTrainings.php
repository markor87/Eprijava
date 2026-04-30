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

    public function mount(): void
    {
        if (!Auth::user()->hasRole('super_admin')) {
            $set = TrainingSet::where('user_id', Auth::id())->first();
            if (!$set) {
                $set = TrainingSet::create(['user_id' => Auth::id()]);
            }
            $this->redirect(TrainingResource::getUrl('edit', ['record' => $set->id]));
            return;
        }

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
