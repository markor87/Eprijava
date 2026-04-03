<?php

namespace App\Filament\Resources\Trainings\Pages;

use App\Filament\Resources\Trainings\TrainingResource;
use App\Models\ExamType;
use App\Models\TrainingSet;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTraining extends EditRecord
{
    protected static string $resource = TrainingResource::class;

    protected function resolveRecord(int|string $key): Model
    {
        return TrainingSet::findOrFail($key);
    }

    protected function afterSave(): void
    {
        $this->record->trainings()
            ->where(fn($q) => $q->where('has_certificate', 0)->orWhereNull('has_certificate'))
            ->update(['issuing_authority' => null, 'exam_date' => null]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $allIds      = ExamType::orderBy('sort_order')->pluck('id');
        $existingIds = $this->record->trainings()->pluck('exam_type_id');

        $allIds->diff($existingIds)->each(function ($examTypeId) {
            $this->record->trainings()->create(['exam_type_id' => $examTypeId]);
        });

        return $data;
    }
}
